<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Rulla\Items\Fields\Field;
use Faker\Generator as Faker;
use Rulla\Items\Fields\FieldType;

$factory->define(Field::class, function (Faker $faker) {
    return [
        'type' => $faker->randomElement(FieldType::getValues()),
        'name' => json_encode(['en' => implode(' ', $faker->words(3))])
    ];
});
