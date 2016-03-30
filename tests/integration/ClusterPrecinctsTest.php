<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Locales\Precinct;
use App\Classes\Locales\Cluster;

class ClusterPrecinctsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_precinct_that_belongs_to_a_cluster() {
        $precinct = factory(Precinct::class)->create(['number' => "1A"]);

        $cluster = factory(Cluster::class)->create();

        $precinct->cluster()->associate($cluster)->save();

        $this->assertEquals("0001A", $cluster->precincts()->first()->number);
    }

    /** @test */
    function a_cluster_has_many_unique_precincts() {
        $precinct1 = factory(Precinct::class)->create(['number' => "1A"]);

        $precinct2 = factory(Precinct::class)->create(['number' => "1B"]);

        $cluster = factory(Cluster::class)->create();

        $cluster->precincts()->saveMany([$precinct1, $precinct2]);

        $this->assertCount(2, $cluster->precincts);

        $cluster->precincts()->save($precinct1);

        $cluster->precincts()->save($precinct2);

        $this->assertCount(2, $cluster->precincts);

        $this->assertEquals("0001A", $cluster->precincts()->first()->number);
    }
}
