<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Classes\Missive;
use App\Events\MissiveWasRecorded;
use App\Classes\User;
use App\Events\MobileWasRegistered;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\MissiveWasRecorded' => [
            'App\Listeners\RelayMissive',
        ],
        'App\Events\MobileWasRegistered' => [
            'App\Listeners\SendBackRegistrationNotice',
            'App\Listeners\RelayRegistrationNotice',
        ],
        'App\Events\TokenFromMissiveMatchedPattern' => [
            'App\Listeners\AutoDesignateWatcher',
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

        Missive::created(function ($model) {
            event(new MissiveWasRecorded($model));
        });

        User::created(function ($model) {
            event(new MobileWasRegistered($model));
        });
    }
}
