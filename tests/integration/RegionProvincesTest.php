<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Province;
use App\Region;

class RegionProvincesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_province_belongs_to_a_region() {
        $province = factory(Province::class)->create(['name' => "Ilocos Norte"]);

        $region = factory(Region::class)->create();

        $province->region()->associate($region)->save();

        $this->assertEquals("Ilocos Norte", $region->provinces()->first()->name);
    }

    /** @test */
    function a_region_has_many_unique_provinces() {
        $province1 = factory(Province::class)->create(['name' => "Ilocos Norte"]);

        $province2 = factory(Province::class)->create(['name' => "Ilocos Sur"]);

        $region = factory(Region::class)->create();

        $region->provinces()->saveMany([$province1, $province2]);

        $this->assertCount(2, $region->provinces);

        $region->provinces()->save($province1);

        $region->provinces()->save($province2);

        $this->assertCount(2, $region->provinces);

        $this->assertEquals("Ilocos Norte", $region->provinces()->first()->name);
    }
}
