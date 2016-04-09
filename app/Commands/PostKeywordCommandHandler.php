<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 06/04/16
 * Time: 15:29
 */

namespace App\Commands;

use App\Classes\Commanding\CommandHandler;
use App\Classes\Repositories\Interfaces\PostRepositoryInterface;
use App\Classes\Repositories\Interfaces\UserRepositoryInterface;

class PostKeywordCommandHandler extends CommandHandler
{
    public function handle($command)
    {
        $user = \App::make(UserRepositoryInterface::class)->find($command->mobile);

        if ( !is_null($user) )
        {
            $keywordClasses = getKeywordClasses();

            foreach ($keywordClasses as $keywordClass)
            {
                $obj = \App::make($keywordClass);

                if (preg_match($obj->getPattern(), $command->keyword, $matches))
                {
                    $post = \App::make(PostRepositoryInterface::class)->firstOrNew(
                        [
                            'title' => $matches['tag'],
                            'body' => $matches['message'] ?: "empty",
                        ]);

                    $post->user()->associate($user);

                    $post->save();

                    return true;
                }
            }
        }
    }

}