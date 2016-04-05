<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 05/04/16
 * Time: 09:12
 */

namespace App\Classes\Repositories;

use App\Classes\Repositories\Interfaces\UserRepositoryInterface;
use App\Classes\User;

class DbUserRepository implements UserRepositoryInterface
{
    public function create($attributes)
    {
        return User::create($attributes);
    }

    public function find($mobile)
    {
        return User::hasMobile($mobile)->first();
    }

    public function getAll()
    {
        return User::all();
    }
}