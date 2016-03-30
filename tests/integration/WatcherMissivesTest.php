<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Watcher;
use App\Classes\Missive;
use App\Classes\Locales\Pop;
use App\Classes\Locales\Cluster;
use App\Classes\User;
use App\Classes\Post;

class WatcherMissivesTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp() {
        parent::setUp();

        Pop::create([
            'region'    => "REGION IV-A",
            'province'  => "BATANGAS",
            'town'      => "SANTA TERESITA",
            'barangay'  => "POBLACION I",
            'place'     => "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
            'cluster'   => 1,
            'precinct'  => "0001A",
            'registered_voters' => 158
        ]);

        Pop::create([
            'region'    => "REGION IV-A",
            'province'  => "BATANGAS",
            'town'      => "SANTA TERESITA",
            'barangay'  => "POBLACION I",
            'place'     => "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
            'cluster'   => 1,
            'precinct'  => "0002A",
            'registered_voters' => 187
        ]);

        Pop::create([
            'region'    => "REGION IV-A",
            'province'  => "BATANGAS",
            'town'      => "SANTA TERESITA",
            'barangay'  => "POBLACION I",
            'place'     => "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
            'cluster'   => 1,
            'precinct'  => "0003A",
            'registered_voters' => 192
        ]);

        Pop::create([
            'region'    => "REGION IV-A",
            'province'  => "BATANGAS",
            'town'      => "SANTA TERESITA",
            'barangay'  => "POBLACION I",
            'place'     => "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
            'cluster'   => 2,
            'precinct'  => "0004A",
            'registered_voters' => 196
        ]);

        Pop::create([
            'region'    => "REGION IV-A",
            'province'  => "BATANGAS",
            'town'      => "SANTA TERESITA",
            'barangay'  => "POBLACION I",
            'place'     => "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
            'cluster'   => 2,
            'precinct'  => "0005A",
            'registered_voters' => 200
        ]);

        Pop::create([
            'region'    => "REGION IV-A",
            'province'  => "BATANGAS",
            'town'      => "SANTA TERESITA",
            'barangay'  => "POBLACION I",
            'place'     => "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
            'cluster'   => 2,
            'precinct'  => "0006A",
            'registered_voters' => 199
        ]);
    }

    /** @test */
    function a_missive_can_auto_designate_a_watcher()
    {
        $cluster = Cluster::findOrFail(1);

        Missive::create([
            'mobile' => "09189362340",
            'body' => $cluster->token
        ]);

        $this->assertEquals(
            "639189362340",
            Watcher::with('user')->whereHas('user', function($q){
                $q->where('mobile', '=', "639189362340");
            })->firstOrFail()->user->handle
        );

        $this->assertEquals(
            "REGION IV-A",
            Watcher::with('user')->whereHas('user', function($q){
                $q->where('mobile', '=', "639189362340");
            })->firstOrFail()->cluster->place->barangay->town->province->region->name
        );
    }

    /** @test */
    function a_missive_can_auto_create_a_user()
    {
        Missive::create([
            'mobile' => "09181234567",
            'body' => "ABC"
        ]);

        $this->assertEquals('639181234567', User::find(1)->mobile);
    }

    /** @test */
    function a_missive_can_trigger_a_post()
    {
        $cluster = Cluster::findOrFail(1);

        Missive::create([
            'mobile' => "09189362340",
            'body' => $cluster->token
        ]);

        Missive::create([
            'mobile' => "09189362340",
            'body' => "#start The quick brown fox..."
        ]);

        $this->assertEquals(
            "The quick brown fox...",
            Post::with('user')->whereHas('user', function($q){
                $q->whereMobile("639189362340");
            })->where('title','=',"start")->firstOrFail()->body
        );
    }

    /** @test */
    function multiple_missives_with_the_same_content_will_be_discarded()
    {
        $cluster = Cluster::findOrFail(1);

        Missive::create([
            'mobile' => "09189362340",
            'body' => $cluster->token
        ]);

        Missive::create([
            'mobile' => "09189362340",
            'body' => "#start The quick brown fox..."
        ]);

        $this->assertEquals(
            "The quick brown fox...",
            Post::with('user')->whereHas('user', function($q){
                $q->whereMobile("639189362340");
            })->where('title','=',"start")->firstOrFail()->body
        );

        $this->assertCount(1, Post::all());

        Missive::create([
            'mobile' => "09189362340",
            'body' => "#start The quick brown fox..."
        ]);

        $this->assertCount(1, Post::all());
    }
}
