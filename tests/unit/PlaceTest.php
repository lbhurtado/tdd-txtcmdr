<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Locales\Place;

class PlaceTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_place_has_a_name() {
        $place = new Place(['name' => "Sta. Rosa Elementary School"]);

        $this->assertEquals("Sta. Rosa Elementary School", $place->name);
    }
}
