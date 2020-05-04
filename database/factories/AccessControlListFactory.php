<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Rulla\Authentication\Models\ACL\AccessControlList;
use Faker\Generator as Faker;

$factory->define(AccessControlList::class, function (Faker $faker) {
    return [
        'system' => false,
        'data' => [],
    ];
});
