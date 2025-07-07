<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use Tests\FakeHttpClient;
use Tomsgrinbergs\ReqresSdk\DTOs\User;
use Tomsgrinbergs\ReqresSdk\Exceptions\ResourceNotFound;
use Tomsgrinbergs\ReqresSdk\Exceptions\UnknownApiException;
use Tomsgrinbergs\ReqresSdk\Services\UsersService;

class UsersServiceTest extends TestCase
{
    protected FakeHttpClient $client;
    protected UsersService $usersService;

    protected function setUp(): void
    {
        $this->client = new FakeHttpClient();
        $this->usersService = new UsersService($this->client);
    }

    public function test_it_can_get_a_user_by_id(): void
    {
        $this->client->pushResponse([
            'id' => 1,
            'email' => 'john.doe@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'avatar' => 'https://example.com/avatars/image.jpeg',
        ]);

        $user = $this->usersService->get(1);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(1, $user->id);
        $this->assertEquals('john.doe@example.com', $user->email);
        $this->assertEquals('John', $user->first_name);
        $this->assertEquals('Doe', $user->last_name);
        $this->assertEquals('https://example.com/avatars/image.jpeg', $user->avatar);
    }

    public function test_it_throws_not_found_exception_when_user_not_found(): void
    {
        $this->client->pushNotFound();

        $this->expectException(ResourceNotFound::class);

        $this->usersService->get(1);
    }

    public function test_it_throws_unknown_exception_when_unexpected_status_code_is_returned(): void
    {
        $this->client->push(418);

        $this->expectException(UnknownApiException::class);

        $this->usersService->get(1);
    }

    public function test_it_throws_unknown_exception_when_an_error_occurs(): void
    {
        $this->client->pushException();

        $this->expectException(UnknownApiException::class);

        $this->usersService->get(1);
    }
}
