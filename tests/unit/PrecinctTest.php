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
        $precinct = new Precinct(['number' => "1A"]);

        $this->assertEquals("1A", $precinct->number);
    }
}
