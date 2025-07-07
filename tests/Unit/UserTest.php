<?php

namespace Tests\Unit;

use JsonSerializable;
use PHPUnit\Framework\TestCase;
use Tomsgrinbergs\ReqresSdk\DTOs\User;

class UserTest extends TestCase
{
    public function test_it_is_json_serializable(): void
    {
        $user = new User(
            id: 1,
            email: 'john.doe@example.com',
            first_name: 'John',
            last_name: 'Doe',
            avatar: 'https://reqres.in/img/faces/1-image.jpg',
        );

        $this->assertInstanceOf(JsonSerializable::class, $user);
        $this->assertEquals(
            '{"id":1,"email":"john.doe@example.com","first_name":"John","last_name":"Doe","avatar":"https:\/\/reqres.in\/img\/faces\/1-image.jpg"}',
            json_encode($user),
        );
    }

    public function test_it_is_convertable_to_array(): void
    {
        $user = new User(
            id: 1,
            email: 'john.doe@example.com',
            first_name: 'John',
            last_name: 'Doe',
            avatar: 'https://reqres.in/img/faces/1-image.jpg',
        );

        $this->assertEquals([
            'id' => 1,
            'email' => 'john.doe@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'avatar' => 'https://reqres.in/img/faces/1-image.jpg',
        ], $user->toArray());
    }
}
