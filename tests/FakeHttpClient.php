<?php

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

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
        $this->push(200, json_encode([
            'data' => $data,
        ]));
    }

    public function pushPaginatedResponse(array $data, array $paginationData = []): void
    {
        $this->push(200, json_encode([
            'data' => $data,
            'page' => 1,
            'per_page' => count($data),
            'total' => count($data),
            'total_pages' => 1,
            ...$paginationData,
        ]));
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
