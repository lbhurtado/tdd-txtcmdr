<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Jobs\RegisterMobile;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Classes\Repositories\Interfaces\UserRepositoryInterface;

class RegisterMobileTest extends TestCase
{
    use DatabaseTransactions, DispatchesJobs;

    /** @test */
    function a_register_mobile_job_creates_a_user()
    {
        $this->dispatch(new RegisterMobile("09189362340", "Yes, yes, yo"));

        $user = App::make(UserRepositoryInterface::class);

        $this->assertCount(1, $user->getAll());

        $this->assertEquals("639189362340", $user->find("639189362340")->mobile);
    }
}
