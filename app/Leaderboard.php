<?php declare(strict_types=1);

namespace App;

use App\Course;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leaderboard extends Model
{
    protected $fillable = [
        'course_id',
        'total_score',
        'user_id',
    ];

    public function getScoreAttribute($value): int
    {
        // Overkill validation in case the DB data is incorrect for some reason
        if (is_int($value) && $value >= 0) {
            return $value;
        }

        return 0;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public static function getCourseLeaderboard(Course $course, String $scope = "course"): Array
    {
        if ("course" == $scope) {
            $leaderboard = Leaderboard::where('course_id', $course->id)
                ->orderBy('total_score', 'DESC')
                ->get();
        } else {
            $leaderboard = Leaderboard::where('course_id', $course->id)
                ->orderBy('total_score', 'DESC')
                ->with('user')
                ->get();

            $userCountry = optional(\Auth::user())->country_id ?? null;

            if (isset($userCountry)) {
                $leaderboard = $leaderboard->filter(function($entry) use ($userCountry) {
                    return $entry->user->country->id == $userCountry;
                })->values();
            }
        }

        $place = 1;
        $lastScore = $leaderboard->first()->total_score ?? 0;
        $userScore = 0;
        $leaderboardId = 0;
        foreach($leaderboard as $id => $entry) {
            if ($entry->user_id == auth()->user()->id) {
                $userScore = $entry->total_score;
                $leaderboardId = $id;
            }

            if ($lastScore == $entry->total_score) {
                $entry->place = $place;
                continue;
            }

            $place += 1;
            $entry->place = $place;
            $lastScore = $entry->total_score;
        }

        $leaderboard = self::sortUserPosition($leaderboard, $userScore);
        $topLeaderboard = $leaderboard->slice(0,3);
        $lastLeaderboard = $leaderboard->slice(-3,3);
        $currentLeaderboardPosition = $leaderboard->where('user_id', auth()->user()->id)->pluck('place')->first();
        $leaderboardIndex = $leaderboard->where('user_id', auth()->user()->id)->keys()->first();

        // Determine if the current user is not on the top or bottom
        if ($leaderboardIndex < 3 || $leaderboardIndex > (count($leaderboard) - 4)) {
            $currentLeaderboard = $leaderboard->slice(ceil(count($leaderboard) / 2), 3);
        } else {
            $currentLeaderboard = $leaderboard->slice($leaderboardIndex - 1, 3);
        }

        $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::ORDINAL);
        $currentLeaderboardPosition = $numberFormatter->format($currentLeaderboardPosition);

        $shouldRenderLeaderboard = true;
        if (count($leaderboard) < 12) {
            $shouldRenderLeaderboard = false;
        }

        return [$topLeaderboard, $currentLeaderboard, $lastLeaderboard, $currentLeaderboardPosition, $shouldRenderLeaderboard];
    }

    // Weight the current user's score and sort it again so that his/her score "floats" to the top
    private static function sortUserPosition(Collection $leaderboard, int $userScore): Collection
    {
        if (count($leaderboard->where('total_score', $userScore)) > 1) {
            $leaderboard->where('user_id', auth()->user()->id)->first()->total_score += 0.1;
            $leaderboard = $leaderboard->sortByDesc('total_score');
            $leaderboard->where('user_id', auth()->user()->id)->first()->total_score -= 0.1;
        }

        return $leaderboard;
    }
}
