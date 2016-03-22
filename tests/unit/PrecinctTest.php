<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Precinct;

class PrecinctTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_precinct_has_a_number() {
        $precinct = new Precinct(['number' => "0001A"]);

        $this->assertEquals("0001A", $precinct->number);
    }

    /** @test */
    function a_precinct_number_is_zero_padded() {
        $precinct = new Precinct(['number' => "1A"]);

        $this->assertEquals("0001A", $precinct->number);

        $precinct->save();

        $this->seeInDatabase('precincts', ['number' => "1A"], 'sqlite');
    }

    /** @test */
    function a_precinct_has_registered_voters() {
        $precinct = new Precinct(['number' => "1A", 'registered_voters' => 100]);

        $precinct->save();

        $this->assertEquals(100, $precinct->first()->registered_voters);

        $this->seeInDatabase('precincts', ['registered_voters' => 100], 'sqlite');
    }
}
