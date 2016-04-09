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
    public function find($mobile)
    {
        $mobile = formalizeMobile($mobile);

        return User::hasMobile($mobile)->first();
    }

    public function getAll()
    {
        return User::all();
    }

    public function register($mobile, $handle = null)
    {
        $attributes = $handle ? compact('mobile', 'handle') : compact('mobile');

        return User::create($attributes);
    }
}