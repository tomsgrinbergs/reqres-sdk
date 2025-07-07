<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use Tomsgrinbergs\ReqresSdk\DTOs\User;
use Tomsgrinbergs\ReqresSdk\ReqresClient;
use Tomsgrinbergs\ReqresSdk\Services\UsersService;

class UserServiceTest extends TestCase
{
    protected UsersService $usersService;

    protected function setUp(): void
    {
        $client = new ReqresClient(getenv('REQRES_API_KEY'));
        $this->usersService = $client->users;
    }

    public function test_it_can_get_a_user_by_id(): void
    {
        $user = $this->usersService->get(1);

        $this->assertInstanceOf(User::class, $user);
    }
}
