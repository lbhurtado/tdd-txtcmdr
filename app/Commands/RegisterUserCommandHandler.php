<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 06/04/16
 * Time: 10:59
 */

namespace App\Commands;

use App\Classes\Commanding\CommandHandler;
use App\Classes\Repositories\Interfaces\UserRepositoryInterface;
use App\Classes\Repositories\Interfaces\WatcherRepositoryInterface;
use App\Classes\Locales\Cluster;

class RegisterUserCommandHandler extends CommandHandler
{
    public function handle($command)
    {
        $user = \App::make(UserRepositoryInterface::class);

        $watcher = \App::make(WatcherRepositoryInterface::class);

        if ( ! $user->find($command->mobile) )
        {
            $tokenMatched = preg_match(Cluster::$token_pattern, $command->token, $matches);

            if ($tokenMatched)
            {
                $watcher->autoDesignate($command->token, ['mobile' => $command->mobile]);
            }
            else
            {
                $user->create(['mobile' => $command->mobile]);
            }
        }
    }

}