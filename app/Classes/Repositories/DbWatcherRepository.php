<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 05/04/16
 * Time: 09:38
 */

namespace App\Classes\Repositories;

use App\Classes\Repositories\Interfaces\WatcherRepositoryInterface;
use App\Classes\Watcher;
use App\Classes\Locales\Cluster;
use App\Classes\User;
//use App\Classes\MobileTrait;

class DbWatcherRepository implements WatcherRepositoryInterface
{
    public function create($attributes = [])
    {
        return Watcher::create($attributes);
    }

    public function find($mobile)
    {
        $mobile = formalizeMobile($mobile);

        return Watcher::with('user')->whereHas('user',
            function($q) use ($mobile)
            {
                $q->where('mobile', '=', $mobile);
            })->first();
    }

    public function getAll()
    {
        return Watcher::all();
    }

    public function designate(Cluster $cluster, User $user)
    {
        try
        {
            $watcher = Watcher::create()->cluster()->associate($cluster);

            $watcher->user()->save($user);

            $watcher->save();
        }
        catch (Exception $e)
        {
            return false;
        }

        return $watcher;
    }

    public function autoDesignate($token, $attributes = [])
    {
        try
        {
            $user = User::create($attributes);

            $cluster = Cluster::where('token', '=', $token)->firstOrFail();
        }
        catch (Exception $e)
        {
            return false;
        }

        return $this->designate($cluster, $user);
    }
}