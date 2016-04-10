<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Classes\Missive;

class TokenFromMissiveMatchesPattern extends Event
{
    use SerializesModels;

    public $mobile;

    public $token;

    public function __construct($mobile, $token)
    {
        $this->mobile = $mobile;

        $this->token = $token;
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
