<?php

namespace App\Listeners;

use App\Events\MissiveWasPosted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Classes\Watcher;
use App\Classes\Post;
use App\Classes\Repositories\Interfaces\UserRepositoryInterface;

class Poster extends Listener
{

    public function whenMissiveWasPosted(MissiveWasPosted $event)
    {
        foreach(Watcher::$patterns as $key=>$value)
        {
            if (preg_match($value, $event->missive->body, $matches))
            {
                $post = Post::firstOrNew([
                    'title' => $matches['tag'],
                    'body' => $matches['message'],
                ]);

                $user = \App::make(UserRepositoryInterface::class)->find($event->missive->mobile);

                $post->user()->associate($user);

                $post->save();

                return true;
            }
        }
    }
}
