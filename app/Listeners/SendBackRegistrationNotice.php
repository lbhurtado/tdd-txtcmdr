<?php

namespace App\Listeners;

use App\Events\MobileWasRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Classes\Messaging\SMS\Facades\SMS;
use App\Classes\Messaging\SMS\Message;

class SendBackRegistrationNotice implements ShouldQueue
{
    private $template;

    public function __construct($template = null)
    {
        $this->template = $template ?: "sms.reply.default";
    }

    /**
     * Handle the event.
     *
     * @param  MobileWasRegistered  $event
     * @return void
     */
    public function handle(MobileWasRegistered $event)
    {
        $message = new Message($this->template, $event->user->attributesToArray());

        $message->to($event->user->mobile, $event->user->mobile);

        SMS::send($message);

        echo "\nSendBackRegistrationNotice: " . $event->user->mobile;
    }
}
