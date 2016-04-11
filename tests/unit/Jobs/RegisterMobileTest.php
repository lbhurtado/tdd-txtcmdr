<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Jobs\RegisterMobile;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Classes\Repositories\Interfaces\UserRepositoryInterface;
use App\Classes\Repositories\Interfaces\WatcherRepositoryInterface;
use App\Classes\Locales\Cluster;
class RegisterMobileTest extends TestCase
{
    use DatabaseTransactions, DispatchesJobs;

    /** @test */
    function a_register_mobile_job_creates_a_user()
    {
        $this->dispatch(new RegisterMobile("09189362340", "Yes, yes, yo"));

        $userRepository = App::make(UserRepositoryInterface::class);

        $this->assertCount(1, $userRepository->getAll());

        $user = $userRepository->find("639189362340");

        $this->assertEquals("639189362340", $user->mobile);
    }

    /** @test */
    function a_register_mobile_job_creates_a_watcher()
    {
        $cluster = factory(Cluster::class)->create();

        $this->dispatch(new RegisterMobile("09189362340", $cluster->token));

        $watcherRepository = App::make(WatcherRepositoryInterface::class);

        $this->assertCount(1, $watcherRepository->getAll());

        $watcher = $watcherRepository->find("09189362340");

        $this->assertEquals("639189362340", $watcher->user->handle);
    }

    /** @test */
    function a_register_mobile_job_invokes_a_keyword()
    {
        $this->dispatch(new RegisterMobile("09189362340", "start"));

        $userRepository = App::make(UserRepositoryInterface::class);

        $this->assertCount(1, $userRepository->getAll());

        $user = $userRepository->find("639189362340");

        $this->assertEquals("639189362340", $user->mobile);
    }
}
