<?php

namespace Tomsgrinbergs\ReqresSdk\DTOs;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;

abstract class BaseDTO
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
}
