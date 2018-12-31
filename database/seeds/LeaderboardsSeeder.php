<?php

use App\Leaderboard;
use App\Course;
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

        foreach($courses as $course) {
            factory(Leaderboard::class, rand(10, 150))->create([
                'course_id' => $course->id,
            ]);
        }
    }
}
