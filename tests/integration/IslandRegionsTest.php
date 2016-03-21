<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Region;
use App\Island;

class IslandRegionsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_region_belongs_to_an_island() {
        $region = factory(Region::class)->create(['name' => "Ilocos Norte"]);

        $island = factory(Island::class)->create();

        $region->island()->associate($island)->save();

        $this->assertEquals("Ilocos Norte", $island->regions()->first()->name);
    }

    /** @test */
    function an_island_has_many_unique_regions() {
        $region1 = factory(Region::class)->create(['name' => "Region I"]);

        $region2 = factory(Region::class)->create(['name' => "Region IIr"]);

        $island = factory(Island::class)->create();

        $island->regions()->saveMany([$region1, $region2]);

        $this->assertCount(2, $island->regions);

        $island->regions()->save($region1);

        $island->regions()->save($region2);

        $this->assertCount(2, $island->regions);

        $this->assertEquals("Region I", $island->regions()->first()->name);
    }
}
