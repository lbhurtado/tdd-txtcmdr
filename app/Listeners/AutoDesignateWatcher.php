<?php

namespace App\Listeners;

use App\Events\MobileWasRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AutoDesignateWatcher
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MobileWasRegistered  $event
     * @return void
     */
    public function handle(MobileWasRegistered $event)
    {
        //
    }
}
