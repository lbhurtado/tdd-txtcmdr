<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Missive;
use App\Classes\User;
use App\Classes\Post;
use App\Classes\Watcher;
use App\Classes\Group;

class UserMissivesTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        parent::setUp();

        Missive::create([
            'mobile' => "09181234567",
            'body' => "GETHSEMANE"
        ]);
    }

    /** @test */
    function a_missive_can_auto_create_a_user_exclusive_from_watcher()
    {
        $this->assertEquals('639181234567', User::find(1)->mobile);

        $this->assertEmpty(Watcher::find(1));

        $this->assertEmpty(Post::find(1));
    }

    /** @test */
    function a_missive_can_auto_join_a_user_to_a_group()
    {
//        $this->assertNotEmpty(Group::find(1));
//        $this->assertEquals('639181234567', Group::whereName("Gethsemane Parish")->firstOrFail()->members()->find(1)->mobile);
    }

}
