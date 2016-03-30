<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Locales\Town;
use App\Classes\Locales\Province;

class ProvinceTownsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_town_belongs_to_a_province() {
        $town = factory(Town::class)->create(['name' => "Currimao"]);

        $province = factory(Province::class)->create();

        $town->province()->associate($province)->save();

        $this->assertEquals("Currimao", $province->towns()->first()->name);
    }

    /** @test */
    function a_province_has_many_unique_towns() {
        $town1 = factory(Town::class)->create(['name' => "Currimao"]);

        $town2 = factory(Town::class)->create(['name' => "Vintar"]);

        $province = factory(Province::class)->create();

        $province->towns()->saveMany([$town1, $town2]);

        $this->assertCount(2, $province->towns);

        $province->towns()->save($town1);

        $province->towns()->save($town2);

        $this->assertCount(2, $province->towns);

        $this->assertEquals("Currimao", $province->towns()->first()->name);
    }
}
