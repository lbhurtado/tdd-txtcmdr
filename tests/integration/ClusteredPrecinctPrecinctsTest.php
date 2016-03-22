<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Precinct;
use App\ClusteredPrecinct;

class ClusteredPrecinctPrecinctsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_precinct_that_belongs_to_a_clustered_precinct() {
        $precinct = factory(Precinct::class)->create(['number' => "1A"]);

        $clustered_precinct = factory(ClusteredPrecinct::class)->create();

        $precinct->clustered_precinct()->associate($clustered_precinct)->save();

        $this->assertEquals("0001A", $clustered_precinct->precincts()->first()->number);
    }

    /** @test */
    function a_clustered_precinct_has_many_unique_precincts() {
        $precinct1 = factory(Precinct::class)->create(['number' => "1A"]);

        $precinct2 = factory(Precinct::class)->create(['number' => "1B"]);

        $clustered_precinct = factory(ClusteredPrecinct::class)->create();

        $clustered_precinct->precincts()->saveMany([$precinct1, $precinct2]);

        $this->assertCount(2, $clustered_precinct->precincts);

        $clustered_precinct->precincts()->save($precinct1);

        $clustered_precinct->precincts()->save($precinct2);

        $this->assertCount(2, $clustered_precinct->precincts);

        $this->assertEquals("0001A", $clustered_precinct->precincts()->first()->number);
    }
}
