<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Classes\Repositories\Interfaces\UserRepositoryInterface;

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
        $user->register($this->mobile, $this->processUserHandle($this->body));
    }

    protected function processUserHandle()
    {
        return null;
    }
}
