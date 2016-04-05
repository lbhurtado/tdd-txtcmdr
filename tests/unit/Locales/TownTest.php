<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Locales\Town;

class TownTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_town_has_a_name() {
        $town = new Town(['name' => "Currimao"]);

        $this->assertEquals("Currimao", $town->name);
    }
}
