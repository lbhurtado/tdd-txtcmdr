<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Locales\Barangay;
use App\Classes\Locales\Town;

class TownBarangaysTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_barangay_belongs_to_a_town() {
        $barangay = factory(Barangay::class)->create(['name' => "Barangay 1"]);

        $town = factory(Town::class)->create();

        $barangay->town()->associate($town)->save();

        $this->assertEquals("Barangay 1", $town->barangays()->first()->name);
    }

    /** @test */
    function a_town_has_many_unique_barangays() {
        $barangay1 = factory(Barangay::class)->create(['name' => "Barangay 1"]);

        $barangay2 = factory(Barangay::class)->create(['name' => "Barangay 2"]);

        $town = factory(Town::class)->create();

        $town->barangays()->saveMany([$barangay1, $barangay2]);

        $this->assertCount(2, $town->barangays);

        $town->barangays()->save($barangay1);

        $town->barangays()->save($barangay2);

        $this->assertCount(2, $town->barangays);

        $this->assertEquals("Barangay 1", $town->barangays()->first()->name);
    }
}
