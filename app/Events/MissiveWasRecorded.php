<?php

namespace App\Events;

use App\Classes\Missive;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MissiveWasRecorded extends Event
{
    use SerializesModels;

    public $missive;

    /**
     * MissiveWasRecorded constructor.
     * @param $missive
     */
    public function __construct(Missive $missive)
    {
        $this->missive = $missive;
    }


    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
