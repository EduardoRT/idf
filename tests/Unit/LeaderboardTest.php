<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Course;
use App\Leaderboard;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeaderboardTest extends TestCase
{
    public function testItCanBeInstantiated(): void
    {
        $this->assertInstanceOf(Leaderboard::class, factory(Leaderboard::class)->make());
    }

    public function testTableName(): void
    {
        $this->assertEquals('leaderboards', (new Leaderboard)->getTable());
    }

    public function testFillableProperty(): void
    {
        $fillable = [
            'course_id',
            'score',
            'user_id',
        ];

        $this->assertEquals($fillable, (new Leaderboard)->getFillable());
    }

    public function testFetchLeaderboard(): void
    {
        $leaderboard = factory(Leaderboard::class)->create();

        $this->assertDatabaseHas((new Leaderboard)->getTable(), $leaderboard->toArray());
    }

    public function testLeaderboardCanBeDeleted(): void
    {
        $leaderboard = factory(Leaderboard::class)->create();
        $this->assertDatabaseHas((new Leaderboard)->getTable(), $leaderboard->toArray());

        $leaderboard->delete();
        $this->assertDatabaseMissing((new Leaderboard)->getTable(), $leaderboard->toArray());
    }

    public function testLeaderboardCanBeUpdated(): void
    {
        $data = factory(Leaderboard::class)->create();
        $leaderboard = factory(Leaderboard::class)->create();
        $leaderboard->fill($data->toArray());
        $leaderboard->save();

        $this->assertDatabaseHas((new Leaderboard)->getTable(), $data->toArray());
    }

    public function testHasUser(): void
    {
        $user = factory(User::class)->create();
        $leaderboard = factory(Leaderboard::class)->create();
        $leaderboard->user_id = $user->id;
        $leaderboard->save();
        $this->assertInstanceOf(Leaderboard::class, $user->leaderboards()->first());
    }

    public function testHasCourse(): void
    {
        $course = factory(course::class)->create();
        $leaderboard = factory(Leaderboard::class)->create();
        $leaderboard->course_id = $course->id;
        $leaderboard->save();
        $this->assertInstanceOf(Leaderboard::class, $course->leaderboards()->first());
    }

    public function testCascadeOnUserDelete(): void
    {
        $user = factory(User::class)->create();
        $leaderboard = factory(Leaderboard::class)->create();
        $leaderboard->user_id = $user->id;
        $leaderboard->save();

        $this->assertDatabaseHas((new Leaderboard)->getTable(), $leaderboard->toArray());
        $this->assertDatabaseHas((new User)->getTable(), $user->toArray());
        $user->delete();
        $this->assertDatabaseMissing((new User)->getTable(), $user->toArray());
        $this->assertDatabaseMissing((new Leaderboard)->getTable(), $leaderboard->toArray());
    }

    public function testCascadeOnCourseDelete(): void
    {
        $course = factory(Course::class)->create();
        $leaderboard = factory(Leaderboard::class)->create();
        $leaderboard->course_id = $course->id;
        $leaderboard->save();

        $this->assertDatabaseHas((new Leaderboard)->getTable(), $leaderboard->toArray());
        $this->assertDatabaseHas((new Course)->getTable(), $course->toArray());
        $course->delete();
        $this->assertDatabaseMissing((new Course)->getTable(), $course->toArray());
        $this->assertDatabaseMissing((new Leaderboard)->getTable(), $leaderboard->toArray());
    }
}
