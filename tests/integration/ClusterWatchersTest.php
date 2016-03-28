<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Cluster;
use App\User;
use App\Watcher;

class ClusterWatchersTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_watcher_is_in_a_cluster () {
        $cluster = Cluster::create();

        $watcher = User::createUser(
            Watcher::class,
            [
                'name' => "Joe",
                'mobile'=>"09189362340",
                'password' => Hash::make("password1")
            ]
        );

        $cluster->watchers()->save($watcher);

        $this->assertCount(1, $cluster->watchers);

        $this->assertEquals(
            "639189362340",
            Cluster::find($cluster->id)
                ->watchers()->first()->user->mobile
        );

        $this->seeInDatabase('users',
            [
                'userable_id' => $watcher->id,
                'userable_type' => Watcher::class,
                'mobile' => "639189362340"
            ],
            'sqlite'
        );

        $this->seeInDatabase('users_watchers',
            [
                'id' => $watcher->user->id,
                'cluster_id' => $cluster->id
            ],
            'sqlite'
        );
    }

    /** @test */
    function watchers_are_distinct_in_a_cluster() {
        $cluster = Cluster::create();

        $watcher1 = User::createUser(
            Watcher::class,
            [
                'name' => "Joe",
                'mobile'=>"09189362340"
            ]
        );

        $watcher2 = User::createUser(
            Watcher::class,
            [
                'name' => "Jess",
                'mobile'=>"09173011987"
            ]
        );

        $this->assertEquals("Joe", Watcher::first()->user->name);

        $cluster->watchers()->save($watcher1);

        $cluster->watchers()->save($watcher2);

        $this->assertCount(2, $cluster->watchers);

        $cluster->watchers()->saveMany([$watcher1, $watcher2]);

        $this->assertCount(2, $cluster->watchers);

        $this->assertEquals(
            "639173011987",
            Cluster::find($cluster->id)
                ->watchers()->with('user')->whereHas('user', function($q){
                    $q->where('name', '=', "Jess");
                })->first()->user->mobile
        );
    }

    /** @test */
    function a_watcher_can_be_automatically_designated_to_a_cluster_using_token_from_a_mobile() {
        $cluster = Cluster::create();

        $watcher = Watcher::autoDesignate($cluster->token,
            [
                'mobile' => "09189362340",
                'handle' => "lbhurtado"
            ]
        );

        $this->assertEquals(
            "639189362340",
            Cluster::find($cluster->id)
                ->watchers()->with('user')->whereHas('user', function($q) use ($watcher){
                    $q->where('handle', '=', "lbhurtado");
                })->firstOrFail()->user->mobile
        );
    }
}
