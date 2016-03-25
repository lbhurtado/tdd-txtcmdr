<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Precinct;
use App\Cluster;
use App\Place;

class PlaceClustersTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_cluster_belongs_to_a_place() {
        $precinct = factory(Precinct::class)->create(['number' => "1A"]);

        $cluster = factory(Cluster::class)->create();

        $precinct->cluster()->associate($cluster)->save();

        $place = factory(Place::class)->create();

        $cluster->place()->associate($place)->save();

        $this->assertEquals("0001A", $place->clusters()->first()->precincts()->first()->number);
    }

    /** @test */
    function a_place_has_many_unique_clusters() {
        $precinct1 = factory(Precinct::class)->create(['number' => "1A"]);

        $precinct2 = factory(Precinct::class)->create(['number' => "1B"]);

        $precinct3 = factory(Precinct::class)->create(['number' => "2A"]);

        $precinct4 = factory(Precinct::class)->create(['number' => "2B"]);

        $cluster1 = new Cluster;

        $cluster1->save();

        $cluster2 = new Cluster;

        $cluster2->save();

        $cluster1->precincts()->saveMany([$precinct1, $precinct2]);

        $cluster2->precincts()->saveMany([$precinct3, $precinct4]);

        $place = factory(Place::class)->create(['name' => "Mohon Elementary School"]);

        $place->clusters()->saveMany([$cluster1, $cluster2]);

        $this->assertCount(2, $place->clusters);

        $place->clusters()->save($cluster1);

        $place->clusters()->save($cluster2);

        $this->assertCount(2, $place->clusters);

        $this->assertEquals("0001A", $place->clusters()->first()->precincts()->first()->number);

        $this->assertEquals(
            "0002B",
            Place::where('name', '=', "Mohon Elementary School")->first()
                ->clusters()->findOrFail($cluster2->id)
                ->precincts()->find($precinct4->id)->number
        );
    }
}
