<?php

namespace Tomsgrinbergs\ReqresSdk\Services;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Throwable;
use Tomsgrinbergs\ReqresSdk\DTOs\BaseDTO;
use Tomsgrinbergs\ReqresSdk\Exceptions\ResourceNotFound;
use Tomsgrinbergs\ReqresSdk\Exceptions\UnknownApiException;
use Tomsgrinbergs\ReqresSdk\ReqresClient;

/**
 * @template T of BaseDTO
 */
abstract class BaseService
{
    abstract protected string $path { get; }

    /** @var class-string<T> */
    abstract protected string $dtoClass { get; }

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
}
