<?php

namespace Tomsgrinbergs\ReqresSdk\DTOs;

class CreateUser extends BaseDTO
{
    public function __construct(
        public string $name,
        public string $job,
    ) {
    }
}
