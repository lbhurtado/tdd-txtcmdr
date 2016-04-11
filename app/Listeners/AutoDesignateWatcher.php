<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\TokenFromMissiveMatchedPattern;
use App\Classes\Repositories\Interfaces\WatcherRepositoryInterface;

class AutoDesignateWatcher
{
    private $watcherRepository;

    /**
     * @param WatcherRepositoryInterface $watcherRepository
     */
    public function __construct(WatcherRepositoryInterface $watcherRepository)
    {
        $this->watcherRepository = $watcherRepository;
    }

    /**
     * @param TokenFromMissiveMatchedPattern $event
     */
    public function handle(TokenFromMissiveMatchedPattern $event)
    {
        $mobile = $event->mobile;
        $this->watcherRepository->autoDesignate($event->token, compact('mobile'));
    }
}
