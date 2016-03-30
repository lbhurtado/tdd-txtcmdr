<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Locales\Place;
use App\Classes\Locales\Barangay;

class BarangayPlacesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_place_belongs_to_a_barangay() {
        $place = factory(Place::class)->create(['name' => "An Elementary School"]);

        $barangay = factory(Barangay::class)->create();

        $place->barangay()->associate($barangay)->save();

        $this->assertEquals("An Elementary School", $barangay->places()->first()->name);
    }

    /** @test */
    function a_barangay_has_many_unique_places() {
        $place1 = factory(Place::class)->create(['name' => "Elementary School 1"]);

        $place2 = factory(Place::class)->create(['name' => "Elementary School 2"]);

        $barangay = factory(Barangay::class)->create();

        $barangay->places()->saveMany([$place1, $place2]);

        $this->assertCount(2, $barangay->places);

        $barangay->places()->save($place1);

        $barangay->places()->save($place2);

        $this->assertCount(2, $barangay->places);

        $this->assertEquals("Elementary School 1", $barangay->places()->first()->name);
    }
}
