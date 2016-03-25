<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Place;
use App\Cluster;

class ClusterTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_cluster_has_a_place_id() {
//        $place = factory(Place::class)->create(
//            [
//                'id' => 100,
//                'name' => "Mohon Elementary School"
//            ]
//        );
//
//        $cluster = new Cluster(['place_id' => $place->id]);
//
//        $this->assertEquals(100, $cluster->place_id);
    }
}
