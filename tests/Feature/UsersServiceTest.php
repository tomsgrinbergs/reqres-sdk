<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use Tomsgrinbergs\ReqresSdk\DTOs\CreateUser;
use Tomsgrinbergs\ReqresSdk\DTOs\User;
use Tomsgrinbergs\ReqresSdk\DTOs\UserPagination;
use Tomsgrinbergs\ReqresSdk\ReqresClient;
use Tomsgrinbergs\ReqresSdk\Services\UsersService;

class UsersServiceTest extends TestCase
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

    public function test_it_can_get_all_users(): void
    {
        $users = $this->usersService->all();

        $this->assertInstanceOf(UserPagination::class, $users);
    }

    public function test_it_can_get_2nd_page_of_all_users(): void
    {
        $users = $this->usersService->all(page: 2);

        $this->assertInstanceOf(UserPagination::class, $users);
        $this->assertEquals(2, $users->page);
    }

    public function test_it_can_add_a_user(): void
    {
        $userId = $this->usersService->create(new CreateUser(
            name: 'John Doe',
            job: 'Software Engineer',
        ));

        $this->assertIsInt($userId);
    }
}
