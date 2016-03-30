<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Locales\Island;

class IslandTest extends TestCase
{
    /** @test */
    function a_region_has_a_name() {
        $island = new Island(['name' => "Luzon"]);

        $this->assertEquals("Luzon", $island->name);
    }
}
