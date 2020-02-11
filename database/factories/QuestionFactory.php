<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Question::class, function (Faker $faker) {
    $poll_ids = DB::table('polls')->pluck('id')->all();
    return [
        'title' => $faker->realText(50),
        'question'=>$faker->realText(500),
        'poll_id' => $faker->randomElement($poll_ids),
    ];
});
