<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Jobs\RecordMissive;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Classes\Repositories\Interfaces\MissiveRepositoryInterface;

class RecordMissiveTest extends TestCase
{
    use DatabaseTransactions, DispatchesJobs;

    /** @test */
    function a_record_missive_job_creates_a_missive()
    {
        $job = new RecordMissive("09189362340", "event raised in boot");

        $this->dispatch($job);

        $missiveRepository = App::make(MissiveRepositoryInterface::class);

        $this->assertCount(1, $missiveRepository->getAll());

        $this->assertEquals("639189362340", $missiveRepository->find(1)->mobile);
    }
}
