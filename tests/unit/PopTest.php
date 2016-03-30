<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Locales\Pop;
use App\Classes\Locales\Region;
use App\Classes\Locales\Province;
use App\Classes\Locales\Town;
use App\Classes\Locales\Barangay;
use App\Classes\Locales\Place;
use App\Classes\Locales\Cluster;
use App\Classes\Locales\Precinct;

class PopTest extends TestCase
{
    use DatabaseTransactions;

    protected $pop;

    protected function setUp() {
        parent::setUp();

        $this->pop = Pop::create([
            'region'    => "REGION IV-A",
            'province'  => "BATANGAS",
            'town'      => "SANTA TERESITA",
            'barangay'  => "POBLACION I",
            'place'     => "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
            'cluster'   => 2,
            'precinct'  => "0004A",
            'registered_voters' => 196
        ]);
    }

    /** @test */
    function a_POP_has_region_province_town_barangay_cluster_precinct_required_fields() {

        $pop = $this->pop;

        $this->assertEquals("REGION IV-A", $pop->region);

        $this->assertEquals("BATANGAS", $pop->province);

        $this->assertEquals("SANTA TERESITA", $pop->town);

        $this->assertEquals("POBLACION I", $pop->barangay);

        $this->assertEquals("STA. TERESITA CENTRAL SCHOOL, POBLACION II", $pop->place);

        $this->assertEquals(2, $pop->cluster);

        $this->assertEquals("0004A", $pop->precinct);

        $this->assertEquals(196, $pop->registered_voters);

        $this->seeInDatabase('pops',
            [
                'region' => "REGION IV-A",
                'province' => "BATANGAS",
                'town' => "SANTA TERESITA",
                'barangay' => "POBLACION I",
                'place' => "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
                'cluster' => 2,
                'precinct' => "0004A",
                'registered_voters' => 196
            ],
            'sqlite'
        );
    }

    /** @test */
    function a_POP_conjures_region_province_town_barangay_cluster_precinct_classes() {
        $this->assertEquals("REGION IV-A", Region::all()->find(1)->name);
        $this->assertEquals("BATANGAS", Province::all()->find(1)->name);
        $this->assertEquals("SANTA TERESITA", Town::all()->find(1)->name);
        $this->assertEquals("POBLACION I", Barangay::all()->find(1)->name);
        $this->assertEquals("STA. TERESITA CENTRAL SCHOOL, POBLACION II", Place::all()->find(1)->name);
        $this->assertEquals(2, Cluster::all()->find(1)->number);
        $this->assertEquals("0004A", Precinct::all()->find(1)->number);
    }
}
