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

$factory->define(\App\Classes\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'mobile' => "0" . rand(900,999) . rand(1000000, 9999999),
        'token' => $faker->randomNumber(4),
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(\App\Classes\Group::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
    ];
});

$factory->define(\App\Classes\Token::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(\App\Classes\User::class)->create()->id,
    ];
});

$factory->define(\App\Classes\Locales\Precinct::class, function (Faker\Generator $faker) {
    return [
        'number' => str_pad($faker->numberBetween(1,9999), 4, STR_PAD_LEFT) . $faker->randomElement(["A", "B", "C", "D", "E"]),
    ];
});

$factory->define(\App\Classes\Locales\Cluster::class, function (Faker\Generator $faker) {
    return [
        'number' => rand(1000000, 9999999),
        'place_id' => factory(\App\Classes\Locales\Place::class)->create()->id
    ];
});

$factory->define(\App\Classes\Locales\Place::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
    ];
});

$factory->define(\App\Classes\Locales\Barangay::class, function (Faker\Generator $faker) {
    return [
        'name' => "Barangay" . $faker->firstNameFemale,
    ];
});

$factory->define(\App\Classes\Locales\Town::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->city,
    ];
});

$factory->define(\App\Classes\Locales\Province::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->randomElement(["Ilocos Norte", "Ilocos Sur", "Pangasinan"]),
    ];
});

$factory->define(\App\Classes\Locales\Region::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->randomElement(["Region I", "Region II", "Region III"]),
    ];
});

$factory->define(\App\Classes\Locales\Island::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->randomElement(["Luzon", "Visayas", "Mindanao"]),
    ];
});

$factory->define(\App\Classes\Watcher::class, function (Faker\Generator $faker) {
    $cluster = factory(\App\Classes\Locales\Cluster::class)->create();
    $id = rand(1000000, 9999999);
    $user = factory(\App\Classes\User::class)->create([
        'id' => $id,
        'userable_id' => $id,
        'userable_type' => \App\Classes\Watcher::class
    ]);
    return [
        'id' => $id,
        'cluster_id' => $cluster->id
    ];
});

$factory->define(\App\Classes\Post::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(\App\Classes\User::class)->create()->id,
        'title' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});