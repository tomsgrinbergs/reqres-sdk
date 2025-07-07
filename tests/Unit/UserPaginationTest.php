<?php

namespace Tests\Unit;

use JsonSerializable;
use PHPUnit\Framework\TestCase;
use Tomsgrinbergs\ReqresSdk\DTOs\User;
use Tomsgrinbergs\ReqresSdk\DTOs\UserPagination;

class UserPaginationTest extends TestCase
{
    private UserPagination $user;

    public function setUp(): void
    {
        $this->user = new UserPagination(
            data: [
                new User(
                    id: 1,
                    email: 'john.doe@example.com',
                    first_name: 'John',
                    last_name: 'Doe',
                    avatar: 'https://reqres.in/img/faces/1-image.jpg',
                ),
            ],
            page: 1,
            per_page: 6,
            total: 12,
            total_pages: 2,
        );
    }

    public function test_it_is_json_serializable(): void
    {
        $this->assertInstanceOf(JsonSerializable::class, $this->user);
        $this->assertEquals(
            '{"data":[{"id":1,"email":"john.doe@example.com","first_name":"John","last_name":"Doe","avatar":"https:\/\/reqres.in\/img\/faces\/1-image.jpg"}],"page":1,"per_page":6,"total":12,"total_pages":2}',
            json_encode($this->user),
        );
    }

    public function test_it_is_convertable_to_array(): void
    {
        $this->assertEquals([
            'data' => [
                [
                    'id' => 1,
                    'email' => 'john.doe@example.com',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'avatar' => 'https://reqres.in/img/faces/1-image.jpg',
                ],
            ],
            'page' => 1,
            'per_page' => 6,
            'total' => 12,
            'total_pages' => 2,
        ], $this->user->toArray());
    }
}
