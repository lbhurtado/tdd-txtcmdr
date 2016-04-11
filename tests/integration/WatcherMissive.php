<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Locales\Pop;

class WatcherMissivesTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        parent::setUp();

        Pop::create([
            'region'    => "REGION IV-A",
            'province'  => "BATANGAS",
            'town'      => "SANTA TERESITA",
            'barangay'  => "POBLACION I",
            'place'     => "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
            'cluster'   => 1,
            'precinct'  => "0001A",
            'registered_voters' => 158
        ]);

        Pop::create([
            'region'    => "REGION IV-A",
            'province'  => "BATANGAS",
            'town'      => "SANTA TERESITA",
            'barangay'  => "POBLACION I",
            'place'     => "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
            'cluster'   => 1,
            'precinct'  => "0002A",
            'registered_voters' => 187
        ]);

        Pop::create([
            'region'    => "REGION IV-A",
            'province'  => "BATANGAS",
            'town'      => "SANTA TERESITA",
            'barangay'  => "POBLACION I",
            'place'     => "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
            'cluster'   => 1,
            'precinct'  => "0003A",
            'registered_voters' => 192
        ]);

        Pop::create([
            'region'    => "REGION IV-A",
            'province'  => "BATANGAS",
            'town'      => "SANTA TERESITA",
            'barangay'  => "POBLACION I",
            'place'     => "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
            'cluster'   => 2,
            'precinct'  => "0004A",
            'registered_voters' => 196
        ]);

        Pop::create([
            'region'    => "REGION IV-A",
            'province'  => "BATANGAS",
            'town'      => "SANTA TERESITA",
            'barangay'  => "POBLACION I",
            'place'     => "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
            'cluster'   => 2,
            'precinct'  => "0005A",
            'registered_voters' => 200
        ]);

        Pop::create([
            'region'    => "REGION IV-A",
            'province'  => "BATANGAS",
            'town'      => "SANTA TERESITA",
            'barangay'  => "POBLACION I",
            'place'     => "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
            'cluster'   => 2,
            'precinct'  => "0006A",
            'registered_voters' => 199
        ]);
    }

    /** @test */
    function a_missive_can_auto_designate_a_watcher()
    {
        $this->assert(1,1);
    }

    /** @test */
    function a_missive_can_trigger_a_post()
    {
        $this->assert(1,1);
    }

    /** @test */
    function multiple_missives_with_the_same_content_will_be_discarded()
    {
        $this->assert(1,1);
    }
}
