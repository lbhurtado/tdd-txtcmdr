<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'mobile' => "0" . rand(900,999) . rand(1000000, 9999999),
        'token' => $faker->randomNumber(4),
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Group::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
    ];
});

$factory->define(App\Token::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(\App\User::class)->create()->id,
    ];
});

$factory->define(App\Precinct::class, function (Faker\Generator $faker) {
    return [
        'number' => str_pad($faker->numberBetween(1,9999), 4, STR_PAD_LEFT) . $faker->randomElement(["A", "B", "C", "D", "E"]),
    ];
});

$factory->define(App\Cluster::class, function (Faker\Generator $faker) {
    return [
        'number' => rand(1000000, 9999999),
        'place_id' => factory(\App\Place::class)->create()->id
    ];
});

$factory->define(App\Place::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
    ];
});

$factory->define(App\Barangay::class, function (Faker\Generator $faker) {
    return [
        'name' => "Barangay" . $faker->firstNameFemale,
    ];
});

$factory->define(App\Town::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->city,
    ];
});

$factory->define(App\Province::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->randomElement(["Ilocos Norte", "Ilocos Sur", "Pangasinan"]),
    ];
});

$factory->define(App\Region::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->randomElement(["Region I", "Region II", "Region III"]),
    ];
});

$factory->define(App\Island::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->randomElement(["Luzon", "Visayas", "Mindanao"]),
    ];
});

$factory->define(App\Watcher::class, function (Faker\Generator $faker) {
    $cluster = factory(\App\Cluster::class)->create();
    $id = rand(1000000, 9999999);
    $user = factory(\App\User::class)->create([
        'id' => $id,
        'userable_id' => $id,
        'userable_type' => \App\Watcher::class
    ]);
    return [
        'id' => $id,
        'cluster_id' => $cluster->id
    ];
});