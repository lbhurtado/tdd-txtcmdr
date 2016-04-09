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
        $relays = config('txtcmdr.sms.relays');

        if (count($relays) > 0)
        {
            $message = new Message($this->template, $event->missive->attributesToArray());

            foreach($relays as $relay) {
                $message->to($relay, $relay);
            }

            SMS::send($message);
        }
    }
}
