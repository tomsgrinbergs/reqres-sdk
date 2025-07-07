<?php

namespace Tomsgrinbergs\ReqresSdk;

use GuzzleHttp\Client;
use Tomsgrinbergs\ReqresSdk\Services\UsersService;

class ReqresClient
{
    public string $baseUrl = 'https://reqres.in/api/';

    // API Services
    public UsersService $users;

    public function __construct(
        public string $apiKey,
    ) {
        $httpClient = new Client([
            'base_uri' => "{$this->baseUrl}",
            'headers' => ['x-api-key' => $this->apiKey],
        ]);

        $this->users = new UsersService($httpClient);
    }
}
