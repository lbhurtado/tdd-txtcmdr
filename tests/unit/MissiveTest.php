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

        $this->seeInDatabase(
            'missives',
            [
                'mobile' => "639189362340",
                'body' => "The quick brown fox"
            ]
        );

        Missive::create([
            'mobile' => "09189362340",
            'body'=>"HERE"
        ]);

        $this->assertEquals(2, Missive::hasMobile('09189362340')->count());
    }

//
//    /** @test */
//    function a_missive_is_a_recorded_activity() {
//        $user = factory(User::class)->create();
//
//        $missive = new Missive(['body'=>"The quick brown fox"]);
//
//        $missive->user()->associate($user)->save();
//
//        $this->assertEquals(Missive::class, Activity::where('subject_id', '=', $missive->id)->first()->subject_type);
//
//        $this->assertEquals(1, Activity::where('subject_id', '=', $missive->id)->first()->user_id);
//
//        $this->assertEquals("created_missive", Activity::where('subject_id', '=', $missive->id)->first()->name);
//
//        $this->seeInDatabase(
//            'activities',
//            [
//                'user_id' => 1,
//                'name' => "created_missive",
//                'subject_type' => Missive::class
//            ]
//        );
//    }
}
