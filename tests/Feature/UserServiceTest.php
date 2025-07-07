<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use Tomsgrinbergs\ReqresSdk\DTOs\User;
use Tomsgrinbergs\ReqresSdk\ReqresClient;

class UserServiceTest extends TestCase
{
    protected ReqresClient $client;

    protected function setUp(): void
    {
        $this->client = new ReqresClient(getenv('REQRES_API_KEY'));
    }

    public function test_it_can_get_a_user_by_id(): void
    {
        $user = $this->client->users->get(1);

        $this->assertInstanceOf(User::class, $user);
    }
}
