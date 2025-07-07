<?php

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client as HttpClient;

class FakeHttpClient extends HttpClient
{
    protected MockHandler $mock;

    public function __construct()
    {
        $this->mock = new MockHandler();

        $handlerStack = HandlerStack::create($this->mock);

        parent::__construct(['handler' => $handlerStack]);
    }

    public function pushResponse(array $data): void
    {
        $this->mock->append(new Response(body: json_encode([
            'data' => $data,
        ])));
    }
}
