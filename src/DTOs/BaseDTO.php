<?php

namespace Tomsgrinbergs\ReqresSdk\DTOs;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;
use CuyZ\Valinor\Normalizer\Format;
use CuyZ\Valinor\NormalizerBuilder;
use JsonSerializable;
use Tomsgrinbergs\ReqresSdk\Exceptions\UnableToSerializePayload;

abstract class BaseDTO implements JsonSerializable
{
    /** @param array<mixed> $data */
    public static function fromArray(array $data): static
    {
        try {
            return (new MapperBuilder())
                ->allowSuperfluousKeys()
                ->mapper()
                ->map(static::class, Source::array($data));
        } catch (MappingError $error) {
            // TODO: handle error properly
            var_dump($error);
            exit;
        }
    }

    /** @return array<mixed> */
    public function toArray(): array
    {
        $normalizer = (new NormalizerBuilder())
            ->normalizer(Format::array());

        $result = $normalizer->normalize($this);

        if (!is_array($result)) {
            throw new UnableToSerializePayload();
        }

        return $result;
    }

    /** @return array<mixed> */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
