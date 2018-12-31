<?php

use App\User;
use App\Course;
use Faker\Generator as Faker;

$factory->define(App\Leaderboard::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'course_id' => factory(Course::class),
        'total_score' => $faker->numberBetween(0,500),
    ];
});
