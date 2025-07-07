<?php

namespace Tomsgrinbergs\ReqresSdk\DTOs;

class CreateUser extends CreateDTO
{
    public function __construct(
        public string $name,
        public string $job,
    ) {
    }
}
