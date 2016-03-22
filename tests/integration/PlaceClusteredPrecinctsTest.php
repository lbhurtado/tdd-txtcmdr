<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Precinct;
use App\ClusteredPrecinct;
use App\Place;

class PlaceClusteredPrecinctsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_clustered_precinct_belongs_to_a_place() {
        $precinct = factory(Precinct::class)->create(['number' => "1A"]);

        $clustered_precinct = factory(ClusteredPrecinct::class)->create();

        $precinct->clustered_precinct()->associate($clustered_precinct)->save();

        $place = factory(Place::class)->create();

        $clustered_precinct->place()->associate($place)->save();

        $this->assertEquals("0001A", $place->clustered_precincts()->first()->precincts()->first()->number);
    }

    /** @test */
    function a_place_has_many_unique_clustered_precincts() {
        $precinct1 = factory(Precinct::class)->create(['number' => "1A"]);

        $precinct2 = factory(Precinct::class)->create(['number' => "1B"]);

        $precinct3 = factory(Precinct::class)->create(['number' => "2A"]);

        $precinct4 = factory(Precinct::class)->create(['number' => "2B"]);

        $clustered_precinct1 = new ClusteredPrecinct;

        $clustered_precinct1->save();

        $clustered_precinct2 = new ClusteredPrecinct;

        $clustered_precinct2->save();

        $clustered_precinct1->precincts()->saveMany([$precinct1, $precinct2]);

        $clustered_precinct2->precincts()->saveMany([$precinct3, $precinct4]);

        $place = factory(Place::class)->create();

        $place->clustered_precincts()->saveMany([$clustered_precinct1, $clustered_precinct2]);

        $this->assertCount(2, $place->clustered_precincts);

        $place->clustered_precincts()->save($clustered_precinct1);

        $place->clustered_precincts()->save($clustered_precinct2);

        $this->assertCount(2, $place->clustered_precincts);

        $this->assertEquals("0001A", $place->clustered_precincts()->first()->precincts()->first()->number);
    }
}
