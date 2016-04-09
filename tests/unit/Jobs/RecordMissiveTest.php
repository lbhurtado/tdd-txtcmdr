<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Jobs\RecordMissive;
use Illuminate\Foundation\Bus\DispatchesJobs;

class RecordMissiveTest extends TestCase
{
    use DatabaseTransactions, DispatchesJobs;

    /** @test */
    function a_record_missive_job_creates_a_missive()
    {
        $job = new RecordMissive("09189362340", "Yes, yes, yo");

        $this->dispatch($job);

        $missive = App::make(\App\Classes\Repositories\Interfaces\MissiveRepositoryInterface::class);

        $this->assertCount(1, $missive->getAll());

        $this->assertEquals("639189362340", $missive->find(1)->mobile);
    }
}
