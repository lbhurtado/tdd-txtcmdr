<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Group;

class GroupTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_group_has_a_unique_name() {

        $group1 = new Group(['name' => "Group 1"]);

        $this->assertEquals("Group 1", $group1->name);

        $group1->save();

        $this->seeInDatabase('groups', ['name' => "Group 1"], 'sqlite');

        $this->setExpectedException(Illuminate\Database\QueryException::class);

        $group2 = Group::create(['name' => "Group 1"]);

        $this->assertCount(2, $group1);
    }
}
