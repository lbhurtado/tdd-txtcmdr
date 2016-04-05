<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 05/04/16
 * Time: 09:37
 */

namespace App\Classes\Repositories\Interfaces;

use App\Classes\Locales\Cluster;
use App\Classes\User;

interface WatcherRepositoryInterface
{
    public function create($attributes);

    public function find($mobile);

    public function getAll();

    public function designate(Cluster $cluster, User $user);

    public function autoDesignate($token, $attributes = []);
}