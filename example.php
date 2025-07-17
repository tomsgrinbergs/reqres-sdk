<?php

require_once 'vendor/autoload.php';

use Tomsgrinbergs\ReqresSdk\DTOs\CreateUser;
use Tomsgrinbergs\ReqresSdk\ReqresClient;

$reqres = new ReqresClient(getenv('REQRES_API_KEY'));

function printExample(string $message, callable $callback): void
{
    echo $message . PHP_EOL;
    print_r($callback());
    echo PHP_EOL;
}

printExample('Get a user by ID', function () use ($reqres) {
    return $reqres->users->get(1)->toArray();
});

printExample('Get 2nd page of all users', function () use ($reqres) {
    return $reqres->users->all(page: 2)->toArray();
});

printExample('Create a new user', function () use ($reqres) {
    return $reqres->users->create(new CreateUser(
        name: 'John Doe',
        job: 'Software Engineer',
    ));
});
