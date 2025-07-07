<?php

namespace Tomsgrinbergs\ReqresSdk\DTOs;

class User extends BaseDTO
{
    public function __construct(
        public int $id,
        public string $email,
        public string $first_name,
        public string $last_name,
        public string $avatar,
    ) {
    }
}
