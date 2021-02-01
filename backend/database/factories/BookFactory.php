<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->faker->seed('1');

$factory->define(Book::class, function (Faker $faker) {

    static $num = 0;
    $num++;

    return [
        'item_name' => 'タイトル' . $num,
        'alphabet_title' => 'title' . $num,
        'item_number' => $faker->numberBetween($min = 1, $max = 100),
        'item_amount' => $faker->numberBetween($min = 100, $max = 100000),
        'published' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now')->format('Y-m-d'),
    ];
});
