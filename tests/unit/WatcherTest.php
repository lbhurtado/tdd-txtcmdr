<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Watcher;
use App\Classes\User;
use App\Classes\Locales\Cluster;
use App\Classes\Repositories\Interfaces\WatcherRepositoryInterface;

class WatcherTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_watcher_is_a_user_within_a_cluster()
    {
        $cluster = Cluster::create();

        $user = User::create([
            'name' => "Joe",
            'mobile'=>"09189362340",
            'password' => Hash::make('password')
        ]);

        $watcher = App::make(WatcherRepositoryInterface::class);

        $watcher->designate($cluster, $user);

        $this->assertEquals(1, $watcher->find('639189362340')->id);

        $this->assertEquals('Joe', $watcher->find('639189362340')->user->name);

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
    function a_watcher_can_be_instantiated_by_a_mobile_attribute_via_scope()
    {
        $cluster = Cluster::create();

        $user = User::create([
            'name' => "Joe",
            'mobile'=>"09189362340",
            'password' => Hash::make('password')
        ]);

        $watcher = App::make(WatcherRepositoryInterface::class)->designate($cluster, $user);

        $this->assertEquals("Joe", Watcher::hasMobile("639189362340")->firstOrFail()->user->name);
    }
}
