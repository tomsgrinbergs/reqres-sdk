<?php

namespace Tomsgrinbergs\ReqresSdk\Services;

use Tomsgrinbergs\ReqresSdk\DTOs\User;
use Tomsgrinbergs\ReqresSdk\DTOs\UserPagination;

/** @extends BaseService<User, UserPagination> */
class UsersService extends BaseService
{
    protected string $path = 'users';
    protected string $dtoClass = User::class;
    protected string $dtoPaginationClass = UserPagination::class;
}
