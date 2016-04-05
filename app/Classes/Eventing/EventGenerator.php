<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 9/23/15
 * Time: 13:09
 */

namespace App\Classes\Eventing;


trait EventGenerator
{
    protected $pendingEvents = [];

    public function raise($event) {
        $this->pendingEvents[] = $event;
    }

    public function releaseEvents() {
        $events = $this->pendingEvents;
        $this->pendingEvents = [];

        return $events;
    }
}