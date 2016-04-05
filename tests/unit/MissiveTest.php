<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Missive;
use App\Classes\User;
use App\Classes\Activity;

class MissiveTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_missive_has_a_body_and_mobile_trait() {
        $missive = new Missive([
            'mobile' => "09189362340",
            'body'=>"The quick brown fox"
        ]);

        $missive->save();

        $this->assertEquals("The quick brown fox", $missive->body);

        $this->assertEquals("639189362340", $missive->mobile);

        $mobile = "639189362340";

        $body = "The quick brown fox";

        $this->seeInDatabase('missives', compact('mobile', 'body'));

        Missive::create([
            'mobile' => "09189362340",
            'body'=>"HERE"
        ]);

        $this->assertEquals(2, Missive::hasMobile('09189362340')->count());
    }

    /** @test */
    function a_missive_can_be_taken_from_a_repository()
    {
        Missive::create([
            'mobile' => "09189362340",
            'body'=>"The quick brown fox"
        ]);

        $missive = App::make(App\Classes\Repositories\MissiveRepositoryInterface::class);

        $this->assertCount(1, $missive->getAll());
    }
}
