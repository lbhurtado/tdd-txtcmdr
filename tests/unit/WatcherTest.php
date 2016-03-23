<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Watcher;
use App\User;

class WatcherTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_watcher_is_a_user_within_a_precinct() {

        $watcher = User::createUser(
            Watcher::class,
            [
                'name' => "Joe",
                'mobile'=>"09189362340",
                'password' => Hash::make('password')
            ],
            [
                'clustered_precinct_id' => "1"
            ]
        );

        $this->assertEquals(1, $watcher->clustered_precinct_id);

        $this->assertEquals('Joe', $watcher->user->name);

        $this->assertEquals('639189362340', $watcher->user->mobile);

        $this->seeInDatabase('users',
            [
                'userable_id' => 1,
                'userable_type' => Watcher::class,
                'mobile' => "639189362340"
            ],
            'sqlite'
        );

        $this->seeInDatabase('users_watchers',
            [
                'id' => 1,
                'clustered_precinct_id' => 1
            ],
            'sqlite'
        );
    }
}
