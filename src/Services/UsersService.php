<?php

namespace Tomsgrinbergs\ReqresSdk\Services;

use Tomsgrinbergs\ReqresSdk\DTOs\User;

/**
 * @extends BaseService<User>
 */
class UsersService extends BaseService
{
    protected string $path = 'users';
    protected string $dtoClass = User::class;
}
