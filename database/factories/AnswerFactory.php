<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Answer::class, function (Faker $faker) {
    $question_ids = DB::table('questions')->pluck('id')->all();
    return [
          'answer'          => $faker->realText(500),
           'question_id'    =>$faker->randomElement($question_ids),
    ];
});
