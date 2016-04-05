<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 9/23/15
 * Time: 13:27
 */

namespace App\Classes\Eventing;

use Event;
use App\Podcast;
use App\Events\PodcastWasPurchased;

class EventDispatcher
{
    public function dispatch(array $events) {
        foreach ($events as $event) {
            Event::fire($event);
        }
    }
}