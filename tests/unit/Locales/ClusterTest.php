<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Locales\Place;
use App\Classes\Locales\Cluster;

class ClusterTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_cluster_has_a_token_that_is_automatically_generated() {
        $cluster = new Cluster();

        $cluster->save();

        $this->assertNotEmpty($cluster->token);
    }

    /** @test */
    function generated_token_has_a_pattern() {
        $pattern = "/^([A-Z]{3})(\\d{4})$/";

        $cluster = Cluster::create();

        $this->assertRegExp($pattern, $cluster->token);
    }

    /** @test */
    function a_cluster_has_a_number() {
        $cluster = Cluster::create(['number' => 2]);

        $this->assertEquals(2, $cluster->number);
    }
}
