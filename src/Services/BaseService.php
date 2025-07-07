<?php

namespace Tomsgrinbergs\ReqresSdk\Services;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Tomsgrinbergs\ReqresSdk\DTOs\BaseDTO;
use Tomsgrinbergs\ReqresSdk\ReqresClient;

/**
 * @template T of BaseDTO
 */
abstract class BaseService
{
    abstract protected string $path { get; }

    /** @var class-string<T> */
    abstract protected string $dtoClass { get; }

    protected Client $httpClient;

    public function __construct(
        protected ReqresClient $client,
    ) {
        $this->httpClient = new Client([
            'base_uri' => "{$this->client->baseUrl}{$this->path}/",
            'headers' => ['x-api-key' => $this->client->apiKey],
        ]);
    }

    /** @return T */
    public function get(int $id): BaseDTO
    {
        try {
            $response = $this->httpClient->get((string) $id);
        } catch (ClientException $e) {
            // TODO: handle error properly
            var_dump($e->getRequest());
            exit;
        }

        /** @var array{ data: array<string, mixed> } $result */
        $result = json_decode($response->getBody()->getContents(), true);

        return $this->dtoClass::fromArray($result['data']);
    }
}
