<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Locales\Region;

class RegionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_region_has_a_name() {
        $region = new Region(['name' => "Region I"]);

        $this->assertEquals("Region I", $region->name);
    }
}
