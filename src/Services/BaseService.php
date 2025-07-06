<?php

namespace Tomsgrinbergs\ReqresSdk\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Tomsgrinbergs\ReqresSdk\ReqresClient;

abstract class BaseService
{
    abstract protected string $path { get; }

    protected Client $httpClient;

    public function __construct(
        protected ReqresClient $client,
    ) {
        $this->httpClient = new Client([
            'base_uri' => "{$this->client->baseUrl}{$this->path}/",
            'headers' => ['x-api-key' => $this->client->apiKey],
        ]);
    }

    public function get(int $id)
    {
        try {
            $response = $this->httpClient->get((string) $id);
        } catch (ClientException $e) {
            // TODO: handle error properly
            var_dump($e->getRequest());
            exit;
        }

        // TODO: use DTO
        return json_decode($response->getBody()->getContents(), true);
    }
}
