<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Country;
use App\Course;
use App\Leaderboard;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeaderboardTest extends TestCase
{
    use RefreshDatabase;

    private const USER_COUNT = 150;

    public function testPositionInLeaderboard(): void
    {
        $course = factory(Course::class)->create();
        $country = factory(Country::class)->create();
        $users = factory(User::class, self::USER_COUNT)->create([
            'country_id' => $country->id,
        ]);

        $this->assertDatabaseHas((new Course)->getTable(), $course->toArray());
        $this->assertDatabaseHas((new Country)->getTable(), $country->toArray());

        foreach($users as $user) {
            factory(Leaderboard::class)->create([
                'course_id' => $course->id,
                'user_id' => $user->id,
            ]);
        }

        $course_leaderboard = Leaderboard::where('course_id', $course->id)->get();
        $this->assertEquals(count($course_leaderboard), self::USER_COUNT);

        $random_user = $course_leaderboard->random()->user;

        $random_user_position = $course_leaderboard->where('user_id', $random_user->id)->keys()->first();

        $this->assertTrue($random_user_position <= count($course_leaderboard));
        $this->assertTrue($random_user_position > 0);
    }
}
