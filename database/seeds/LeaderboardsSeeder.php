<?php

use App\Leaderboard;
use App\Course;
use App\User;
use Illuminate\Database\Seeder;

class LeaderboardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = Course::all();
        $user = User::first();

        foreach($courses as $course) {
            factory(Leaderboard::class, 100)->create([
                'course_id' => $course->id,
            ]);

            factory(Leaderboard::class)->create([
                'course_id' => $course->id,
                'user_id' => $user->id,
            ]);

            for ($i = 0; $i < 30; $i += 1) {
                factory(Leaderboard::class)->create([
                    'course_id' => $course->id,
                    'user_id' => factory(User::class)->create([
                        'country_id' => $user->country_id,
                    ]),
                ]);
            }
        }
    }
}
