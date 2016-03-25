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
use App\Watcher;

class PopWatchersTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp() {
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
    function auto_designate_pop() {
        $cluster = Cluster::find(1);

        $watcher = Watcher::autoDesignate($cluster->token, [
            'mobile' => "09189362340",
            'handle' => "lbhurtado"
        ]);

        $this->assertEquals(
            "STA. TERESITA CENTRAL SCHOOL, POBLACION II",
            Watcher::find($watcher->id)->cluster->place->name
        );

        $this->assertEquals(
            "POBLACION I",
            Watcher::find($watcher->id)->cluster->place->barangay->name
        );

        $this->assertEquals(
            "SANTA TERESITA",
            Watcher::find($watcher->id)->cluster->place->barangay->town->name
        );

        $this->assertEquals(
            "BATANGAS",
            Watcher::find($watcher->id)->cluster->place->barangay->town->province->name
        );

        $this->assertEquals(
            "REGION IV-A",
            Watcher::find($watcher->id)->cluster->place->barangay->town->province->region->name
        );
    }

    /** @test */
    function cluster_has_a_clustered_precincts_attribute() {
        $cluster = Cluster::find(1);

        $watcher = Watcher::autoDesignate($cluster->token, [
            'mobile' => "09189362340",
            'handle' => "lbhurtado"
        ]);

        $this->assertEquals(
            "0001A 0002A 0003A",
            Watcher::hasMobile("09189362340")->firstOrFail()->cluster->clustered_precincts
        );
    }

    /** @test */
    function cluster_has_a_designation_attribute() {
        $cluster = Cluster::find(1);

        $watcher = Watcher::autoDesignate($cluster->token, [
            'mobile' => "09189362340",
            'handle' => "lbhurtado"
        ]);

        $input = array();

        array_push($input, "Clustered Precincts 0001A 0002A 0003A");
        array_push($input, "Cluster #1");
        array_push($input, "STA. TERESITA CENTRAL SCHOOL, POBLACION II");
        array_push($input, "POBLACION I");
        array_push($input, "SANTA TERESITA");
        array_push($input, "BATANGAS");
//        array_push($input, "REGION IV-A");

        $this->assertEquals(
            implode("\n", $input),
            Watcher::hasMobile("09189362340")->firstOrFail()->cluster->designation
        );
    }

    /** @test */
    function cluster_has_a_total_registered_voters_attribute() {
        $cluster = Cluster::find(1);

        $this->assertEquals(537, $cluster->total_registered_voters);
    }
}
