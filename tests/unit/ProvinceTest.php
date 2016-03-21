<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Province;

class ProvinceTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_province_has_a_name() {
        $province = new Province(['name' => "Ilocos Norte"]);

        $this->assertEquals("Ilocos Norte", $province->name);
    }
}
