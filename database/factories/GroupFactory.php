<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Rulla\Authentication\Models\Groups\Group;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, true),
    ];
});
