<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\TokenFromMissiveMatchesPattern;
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
     * @param TokenFromMissiveMatchesPattern $event
     */
    public function handle(TokenFromMissiveMatchesPattern $event)
    {
        $mobile = $event->mobile;
        $this->watcherRepository->autoDesignate($event->token, compact('mobile'));
    }
}
