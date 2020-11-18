<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Word;
use Faker\Generator as Faker;

$factory->define(Word::class, function (Faker $faker) {
    $word = $faker->unique()->word;
    return [
        'word' => $word,
    ];
});
