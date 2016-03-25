<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Pop;
use App\Region;
use App\Province;
use App\Town;
use App\Barangay;
use App\Place;
use App\Cluster;
use App\Precinct;

class PopClustersTest extends TestCase
{
    use DatabaseTransactions;

    protected $pop;

    protected function setUp() {
        parent::setUp();

        $this->pop = Pop::create([
            'region' => "REGION IV-A",
            'province' => "BATANGAS",
            'town' => "SANTA TERESITA",
            'barangay' => "POBLACION I",
            'place' => "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
            'cluster' => 2,
            'precinct' => "0004A",
            'registered_voters' => 196
        ]);
    }

    /** @test */
    function a_POP_conjures_a_connected_clustered_precinct() {
        $this->assertEquals(
            2,
            Precinct::whereNumber("4A")->firstOrFail()->cluster->number
        );

        $this->assertEquals(
            "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
            Precinct::whereNumber("4A")->firstOrFail()->cluster->place->name
        );

        $this->assertEquals(
            "POBLACION I",
            Precinct::whereNumber("4A")->firstOrFail()->cluster->place->barangay->name
        );

        $this->assertEquals(
            "SANTA TERESITA",
            Precinct::whereNumber("4A")->firstOrFail()->cluster->place->barangay->town->name
        );

        $this->assertEquals(
            "BATANGAS",
            Precinct::whereNumber("4A")->firstOrFail()->cluster->place->barangay->town->province->name
        );

        $this->assertEquals(
            "REGION IV-A",
            Precinct::whereNumber("4A")->firstOrFail()->cluster->place->barangay->town->province->region->name
        );
    }
}
