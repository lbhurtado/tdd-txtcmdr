<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 06/04/16
 * Time: 15:29
 */

namespace App\Commands;

use App\Classes\Commanding\CommandHandler;
use App\Classes\Watcher;
use App\Classes\Repositories\Interfaces\PostRepositoryInterface;
use App\Classes\Repositories\Interfaces\UserRepositoryInterface;

class PostKeywordCommandHandler extends CommandHandler
{
    public function handle($command)
    {
        foreach(Watcher::$patterns as $key=>$value)
        {
            if (preg_match($value, $command->body, $matches))
            {
                $post = \App::make(PostRepositoryInterface::class)->firstOrNew(
                    [
                        'title' => $matches['tag'],
                        'body' => $matches['message'],
                    ]);

                $user = \App::make(UserRepositoryInterface::class)->find($command->mobile);

                $post->user()->associate($user);

                $post->save();

                return true;
            }
        }
    }

}