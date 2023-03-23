<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use App\Services\BaseService;
use DB;
class UserRepository extends BaseService implements UserInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
