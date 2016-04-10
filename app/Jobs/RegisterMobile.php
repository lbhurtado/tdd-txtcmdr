<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Classes\Repositories\Interfaces\UserRepositoryInterface;
use App\Classes\Locales\Cluster;
use App\Events\TokenFromMissiveMatchesPattern;

class RegisterMobile extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $mobile;

    protected $body;

    /**
     * RegisterMobile constructor.
     * @param $body
     * @param $mobile
     */
    public function __construct($mobile, $body)
    {
        $this->body = $body;
        $this->mobile = $mobile;
    }

    public function handle(UserRepositoryInterface $user)
    {
        $user->register($this->mobile, null); // update null to handle

        $this->processMessage();
    }

    protected function processMessage()
    {
        if (preg_match(Cluster::$token_pattern, $this->body))
        {
            event(new TokenFromMissiveMatchesPattern($this->mobile, $this->body));
        }
    }
}
