<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Watcher;
use App\Classes\User;
use App\Classes\Locales\Cluster;

class WatcherTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_watcher_is_a_user_within_a_cluster() {

        $cluster = Cluster::create();

        $user = User::create([
            'name' => "Joe",
            'mobile'=>"09189362340",
            'password' => Hash::make('password')
        ]);

        $watcher = Watcher::designate($cluster, $user);

        $this->assertEquals(1, $watcher->cluster_id);

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
                'cluster_id' => 1
            ],
            'sqlite'
        );
    }

    /** @test */
    function a_watcher_can_be_instantiated_by_a_mobile_attribute_via_scope() {
        $cluster = Cluster::create();

        $user = User::create([
            'name' => "Joe",
            'mobile'=>"09189362340",
            'password' => Hash::make('password')
        ]);

        Watcher::designate($cluster, $user);

        $this->assertEquals("Joe", Watcher::hasMobile("639189362340")->firstOrFail()->user->name);
    }
}
