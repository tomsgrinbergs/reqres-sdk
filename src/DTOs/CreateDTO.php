<?php

namespace Tomsgrinbergs\ReqresSdk\DTOs;

use CuyZ\Valinor\Normalizer\Format;
use CuyZ\Valinor\NormalizerBuilder;
use Tomsgrinbergs\ReqresSdk\Exceptions\UnableToSerializePayload;

abstract class CreateDTO
{
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
}
