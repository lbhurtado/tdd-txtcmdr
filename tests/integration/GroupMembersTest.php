<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Group;
use App\User;

class GroupMembersTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
//    function a_user_can_join_a_group() {
//        $group = factory(Group::class)->create();
//
//        $user = factory(User::class)->create();
//
//        $user->group()->associate($group)->save();
//
//        $this->assertEquals($user->id, $group->members[0]->id);
//
//        $this->assertEquals($group->id, $user->group->id);
//    }

    /** @test */
    function users_can_join_multiple_groups() {
        $group1 = factory(Group::class)->create(['name' => "Philippines"]);
        $group2 = factory(Group::class)->create(['name' => "Australia"]);
        $group3 = factory(Group::class)->create(['name' => "Internet"]);

        $user1 = factory(User::class)->create(['name' => "Lester"]);
        $user2 = factory(User::class)->create(['name' => "Dene"]);
        $user3 = factory(User::class)->create(['name' => "Glen"]);
        $user4 = factory(User::class)->create(['name' => "Jo Anna"]);
        $user5 = factory(User::class)->create(['name' => "Rowena"]);

        $user1->groups()->attach($group1->id);
        $user2->groups()->attach($group1->id);
        $user5->groups()->attach($group1->id);
        $user3->groups()->attach($group2->id);
        $user4->groups()->attach($group2->id);

        $user1->groups()->attach($group3->id);
        $user2->groups()->attach($group3->id);
        $user5->groups()->attach($group3->id);
        $user3->groups()->attach($group3->id);
        $user4->groups()->attach($group3->id);

        $this->assertEquals("Lester", Group::whereName("Philippines")->firstOrFail()->members()->find($user1->id)->name);
        $this->assertEquals("Dene", Group::whereName("Philippines")->firstOrFail()->members()->find($user2->id)->name);
        $this->assertEquals("Glen", Group::where(['name' => "Australia"])->firstOrFail()->members()->find($user3->id)->name);
        $this->assertEquals("Jo Anna", Group::where(['name' => "Australia"])->firstOrFail()->members()->find($user4->id)->name);
        $this->assertEquals("Rowena", Group::where(['name' => "Philippines"])->firstOrFail()->members()->find($user5->id)->name);

        $this->assertEquals('Philippines', User::whereName("Lester")->firstOrFail()->groups()->find($group1->id)->name);

        var_dump($user1->groups()->lists('name'));

        var_dump($group3->members()->lists('name'));

        $this->seeInDatabase('group_user', ['user_id' => $user1->id, 'group_id' => $group1->id], 'sqlite');
        $this->seeInDatabase('group_user', ['user_id' => $user2->id, 'group_id' => $group1->id], 'sqlite');
        $this->seeInDatabase('group_user', ['user_id' => $user3->id, 'group_id' => $group2->id], 'sqlite');
        $this->seeInDatabase('group_user', ['user_id' => $user4->id, 'group_id' => $group2->id], 'sqlite');
        $this->seeInDatabase('group_user', ['user_id' => $user5->id, 'group_id' => $group1->id], 'sqlite');
        $this->seeInDatabase('group_user', ['user_id' => $user1->id, 'group_id' => $group3->id], 'sqlite');
        $this->seeInDatabase('group_user', ['user_id' => $user2->id, 'group_id' => $group3->id], 'sqlite');
        $this->seeInDatabase('group_user', ['user_id' => $user3->id, 'group_id' => $group3->id], 'sqlite');
        $this->seeInDatabase('group_user', ['user_id' => $user4->id, 'group_id' => $group3->id], 'sqlite');
        $this->seeInDatabase('group_user', ['user_id' => $user5->id, 'group_id' => $group3->id], 'sqlite');
    }
}
