<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 05/04/16
 * Time: 09:08
 */

namespace App\Listeners;

use App\Events\MissiveWasPosted;
use App\Classes\Repositories\Interfaces\UserRepositoryInterface;
use App\Classes\Repositories\Interfaces\WatcherRepositoryInterface;
use App\Classes\Locales\Cluster;

class RegisterWatcher extends Listener
{
    public function whenMissiveWasPosted(MissiveWasPosted $event)
    {
        $user = \App::make(UserRepositoryInterface::class);

        $watcher = \App::make(WatcherRepositoryInterface::class);

        if ( ! $user->find($event->missive->mobile) )
        {
            $tokenMatched = preg_match(Cluster::$token_pattern, $event->missive->body, $matches);

            if ($tokenMatched)
            {
                $watcher->autoDesignate($event->missive->body, ['mobile' => $event->missive->mobile]);
            }
            else
            {
                $user->create(['mobile' => $event->missive->mobile]);
            }
        }
    }
}