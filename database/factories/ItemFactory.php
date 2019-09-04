<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Rulla\Items\Instances\Item;
use Faker\Generator as Faker;

function randomName(Faker $faker) {
    $name = '';

    for ($i = 0; $i < 2 + $faker->randomDigit; $i++) {
        $name .= $faker->randomLetter;
    }

    return strtoupper($name);
}

$factory->define(Item::class, function (Faker $faker) {
    return [
        'tag' => $faker->boolean ? randomName($faker) : null,
    ];
});
