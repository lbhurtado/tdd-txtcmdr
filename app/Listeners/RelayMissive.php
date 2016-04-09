<?php

namespace App\Listeners;

use App\Events\MissiveWasRecorded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Classes\Messaging\SMS\Facades\SMS;
use App\Classes\Messaging\SMS\Message;

class RelayMissive implements ShouldQueue
{
    private $template;

    public function __construct($template = null)
    {
        $this->template = $template ?: "sms.relay.default";
    }

    /**
     * Handle the event.
     *
     * @param  MissiveWasRecorded  $event
     * @return void
     */
    public function handle(MissiveWasRecorded $event)
    {
        $message = (new Message($this->template, $event->missive->attributesToArray()))
            ->to('Globe', '09173011987')
            ->to('Smart', '09189362340');

        SMS::send($message);
    }
}
