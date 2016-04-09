<?php

namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Classes\Repositories\Interfaces\MissiveRepositoryInterface;
use Illuminate\Foundation\Bus\DispatchesJobs;

class RecordMissive extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $mobile;

    protected $body;

    /**
     * RecordMissive constructor.
     * @param $body
     * @param $mobile
     */
    public function __construct($mobile, $body)
    {
        $this->mobile = $mobile;
        $this->body = $body;
    }


    /**
     * @param MissiveRepositoryInterface $missive
     */
    public function handle(MissiveRepositoryInterface $missive)
    {
        $missive->record($this->mobile, $this->body);
    }
}
