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

    /** @return T */
    public function get(int $id): BaseDTO
    {
        try {
            $response = $this->httpClient->get("{$this->path}/{$id}");
        } catch (ClientException $e) {
            if ($e->getCode() === 404) {
                throw new ResourceNotFound("Resource not found: {$this->path}/{$id}");
            }

            throw new UnknownApiException('An unexpected error occurred', previous: $e);
        } catch (Throwable $e) {
            throw new UnknownApiException('An unexpected error occurred', previous: $e);
        }

        /** @var array{ data: array<string, mixed> } $result */
        $result = json_decode($response->getBody()->getContents(), true);

        return $this->dtoClass::fromArray($result['data']);
    }

    /** @return TPagination */
    public function all(int $page = 1): PaginationDTO
    {
        try {
            $response = $this->httpClient->get("{$this->path}", [
                'query' => ['page' => $page],
            ]);
        } catch (ClientException $e) {
            if ($e->getCode() === 404) {
                throw new ResourceNotFound("Resource not found: {$this->path}");
            }

            throw new UnknownApiException('An unexpected error occurred', previous: $e);
        } catch (Throwable $e) {
            throw new UnknownApiException('An unexpected error occurred', previous: $e);
        }

        /** @var array{ data: array<string, mixed> } $result */
        $result = json_decode($response->getBody()->getContents(), true);

        return $this->dtoPaginationClass::fromArray($result);
    }

    public function create(CreateDTO $data): int
    {
        try {
            $response = $this->httpClient->post("{$this->path}", [
                'json' => $data->toArray(),
            ]);
        } catch (ClientException $e) {
            if ($e->getCode() === 404) {
                throw new ResourceNotFound("Resource not found: {$this->path}");
            }

            throw new UnknownApiException('An unexpected error occurred', previous: $e);
        } catch (Throwable $e) {
            throw new UnknownApiException('An unexpected error occurred', previous: $e);
        }

        /** @var array{ id: int } $result */
        $result = json_decode($response->getBody()->getContents(), true);

        return $result['id'];
    }
}
