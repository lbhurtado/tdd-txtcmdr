<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 9/26/15
 * Time: 21:49
 */

namespace App\Listeners;

use App\Events\MissiveWasPosted;

class Logger extends Listener
{
    public function whenMissiveWasPosted(MissiveWasPosted $event)
    {
        \Log::info("Missive was posted: [{$event->missive->mobile}] {$event->missive->body}.");
    }
}