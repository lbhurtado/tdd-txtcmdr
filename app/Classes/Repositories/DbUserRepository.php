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
use App\Classes\MobileTrait;

class DbUserRepository implements UserRepositoryInterface
{
    public function create($attributes)
    {
        return User::create($attributes);
    }

    public function find($mobile)
    {
        $mobile = MobileTrait::formalize($mobile);

        return User::hasMobile($mobile)->first();
    }

    public function getAll()
    {
        return User::all();
    }
}