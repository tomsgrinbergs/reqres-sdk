<?php

namespace Tomsgrinbergs\ReqresSdk\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Throwable;
use Tomsgrinbergs\ReqresSdk\DTOs\BaseDTO;
use Tomsgrinbergs\ReqresSdk\DTOs\CreateDTO;
use Tomsgrinbergs\ReqresSdk\DTOs\PaginationDTO;
use Tomsgrinbergs\ReqresSdk\Exceptions\ResourceNotFound;
use Tomsgrinbergs\ReqresSdk\Exceptions\UnknownApiException;

/**
 * @template T of BaseDTO
 * @template TPagination of PaginationDTO<T>
 * @template TCreate of CreateDTO
 */
abstract class BaseService
{
    abstract protected string $path { get; }

    /** @var class-string<T> */
    abstract protected string $dtoClass { get; }

    /** @var class-string<TPagination> */
    abstract protected string $dtoPaginationClass { get; }

    /** @var class-string<TCreate> */
    abstract protected string $dtoCreateClass { get; }

    public function __construct(
        protected Client $httpClient,
    ) {
    }

    /**
     * @param array<string, mixed> $options
     */
    private function request(string $method, string $path, array $options = []): mixed
    {
        try {
            $response = $this->httpClient->request($method, $path, $options);
        } catch (ClientException $e) {
            if ($e->getCode() === 404) {
                throw new ResourceNotFound("Resource not found: {$path}");
            }

            throw new UnknownApiException('An unexpected error occurred', previous: $e);
        } catch (Throwable $e) {
            throw new UnknownApiException('An unexpected error occurred', previous: $e);
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    /** @return T */
    public function get(int $id): BaseDTO
    {
        /** @var array{ data: array<string, mixed> } $result */
        $result = $this->request('GET', "{$this->path}/{$id}");

        return $this->dtoClass::fromArray($result['data']);
    }

    /** @return TPagination */
    public function all(int $page = 1): PaginationDTO
    {
        /** @var array{ data: array<string, mixed> } $result */
        $result = $this->request('GET', $this->path, [
            'query' => ['page' => $page],
        ]);

        return $this->dtoPaginationClass::fromArray($result);
    }

    public function create(CreateDTO $data): int
    {
        /** @var array{ id: int } $result */
        $result = $this->request('POST', $this->path, [
            'json' => $data->toArray(),
        ]);

        return $result['id'];
    }
}
