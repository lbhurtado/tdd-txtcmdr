<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 05/04/16
 * Time: 09:10
 */

namespace App\Classes\Repositories\Interfaces;


interface UserRepositoryInterface
{
    public function create($attributes);

    public function find($mobile);

    public function getAll();

    public function register($mobile, $handle = null);
}