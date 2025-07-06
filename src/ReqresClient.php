<?php

namespace Tomsgrinbergs\ReqresSdk;

use Tomsgrinbergs\ReqresSdk\Services\UsersService;

class ReqresClient
{
    public string $baseUrl = 'https://reqres.in/api/';

    // API Services
    public UsersService $users;

    public function __construct(
        public string $apiKey,
    ) {
        $this->users = new UsersService($this);
    }
}
