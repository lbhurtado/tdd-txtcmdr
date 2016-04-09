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

    public function handle(UserRepositoryInterface $userRepositoryInterface)
    {
        $userHandle = $this->processUserHandle($this->body);
        $userRepositoryInterface->register($this->mobile, $userHandle);
    }

    protected function processUserHandle()
    {
        return null;
    }
}
