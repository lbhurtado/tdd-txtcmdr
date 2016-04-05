<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\MissiveWasPosted;
use App\Listeners\Logger;
use App\Listeners\RegisterWatcher;
use App\Listeners\Poster;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
        MissiveWasPosted::class => [
            Logger::class,
            RegisterWatcher::class,
            Poster::class,
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

//        Post::created(function($post){
//            Activity::create([
//                'subject_id' => $post->id,
//                'subject_type' => get_class($post),
//                'name' => 'created_post',
//                'user_id' => $post->user_id
//            ]);
//        });
    }
}
