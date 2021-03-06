<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \ReflectionClass;

abstract class Listener
{
    /**
     * @param $event
     * @return mixed
     */
    public function handle($event)
    {
        $eventName = $this->getEventName($event);

        if ($this->listenerIsRegistered($eventName))
        {
            return call_user_func([$this, 'when' . $eventName], $event);
        }
    }

    /**
     * @param $event
     * @return string
     */
    protected function getEventName($event)
    {
        $eventName = (new \ReflectionClass($event))->getShortName();

        return $eventName;
    }

    /**
     * @param $eventName
     * @return bool
     */
    protected function listenerIsRegistered($eventName)
    {
        $method = "when{$eventName}";

        return method_exists($this, $method);
    }
}
