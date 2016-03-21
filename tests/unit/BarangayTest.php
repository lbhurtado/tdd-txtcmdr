<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Town;

class BarangayTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_barangay_has_a_name() {
        $barangay = new Town(['name' => "Poblacion"]);

        $this->assertEquals("Poblacion", $barangay->name);
    }
}
