<?php

namespace Tests;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class FakeHttpClient extends HttpClient
{
    protected MockHandler $mock;

    public function __construct()
    {
        $this->mock = new MockHandler();

        $handlerStack = HandlerStack::create($this->mock);

        parent::__construct(['handler' => $handlerStack]);
    }

    public function push(int $status = 200, ?string $body = null): void
    {
        $this->mock->append(new Response(status: $status, body: $body));
    }

    public function pushResponse(array $data): void
    {
        $this->push(200, json_encode($data));
    }

    public function pushNotFound(): void
    {
        $this->push(404);
    }

    public function pushException(): void
    {
        $this->mock->append(
            new RequestException('Error Communicating with Server', new Request('GET', 'test'))
        );
    }
}
