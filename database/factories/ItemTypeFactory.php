<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Rulla\Items\Types\ItemType;
use Faker\Generator as Faker;

function modelName(Faker $faker) {
    $name = '';

    for ($i = 0; $i < $faker->numberBetween(1, 6); $i++) {
        $name .= $faker->boolean(65) ? $faker->randomLetter : $faker->randomDigit;
    }

    $name .= '-';

    for ($i = 0; $i < 4; $i++) {
        $name .= $faker->boolean ? $faker->randomLetter : $faker->randomDigit;
    }

    $name = strtoupper($name);

    if ($faker->boolean(33)) {
        $name .= ' Pro';
    } else if ($faker->boolean) {
        $name .= ' Plus';
    }
    return $name;
}

$factory->define(ItemType::class, function (Faker $faker) {

    return [
        'parent_id' => 1,
        'name' => $faker->lastName . ' ' . $faker->randomElement(['LLC', 'Ltd', 'Co.', 'GmbH', 'oy', 'AB']) . ' ' . modelName($faker),
    ];
});

$factory->define(ItemType::class, function (Faker $faker) {
    return [
        'parent_id' => 2,
        'name' => 'Room ' . strtoupper($faker->randomLetter . $faker->randomDigit . $faker->randomDigit . $faker->randomDigit),
    ];
}, 'location');
