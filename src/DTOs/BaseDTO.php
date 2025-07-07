<?php

namespace Tomsgrinbergs\ReqresSdk\DTOs;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;
use CuyZ\Valinor\Normalizer\Format;
use CuyZ\Valinor\NormalizerBuilder;
use JsonSerializable;
use Throwable;
use Tomsgrinbergs\ReqresSdk\Exceptions\ErrorParsingResponse;
use Tomsgrinbergs\ReqresSdk\Exceptions\UnableToSerializePayload;

abstract class BaseDTO implements JsonSerializable
{
    /**
     * @param array<mixed> $data
     * @throws ErrorParsingResponse
     */
    public static function fromArray(array $data): static
    {
        try {
            return (new MapperBuilder())
                ->allowSuperfluousKeys()
                ->mapper()
                ->map(static::class, Source::array($data));
        } catch (Throwable $th) {
            throw new ErrorParsingResponse(
                "Error parsing response for " . static::class . ": " . $th->getMessage(),
                previous: $th
            );
        }
    }

    /**
     * @return array<mixed>
     * @throws UnableToSerializePayload
     */
    public function toArray(): array
    {
        try {
            $normalizer = (new NormalizerBuilder())
                ->normalizer(Format::array());

            $result = $normalizer->normalize($this);
        } catch (Throwable $th) {
            throw new UnableToSerializePayload(
                "Error serializing payload for " . static::class . ": " . $th->getMessage(),
                previous: $th
            );
        }

        if (!is_array($result)) {
            throw new UnableToSerializePayload();
        }

        return $result;
    }

    /**
     * @return array<mixed>
     * @throws UnableToSerializePayload
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
