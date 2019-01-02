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

            $user_country = optional(\Auth::user())->country_id ?? null;

            if (isset($user_country)) {
                $leaderboard = $leaderboard->filter(function($entry) use ($user_country) {
                    return $entry->user->country->id == $user_country;
                })->values();
            }
        }

        $currentLeaderboardPosition = (new self)->getCurrentLeaderboardPosition($leaderboard);

        $topLeaderboard = $leaderboard->slice(0,3);
        $lastLeaderboard = $leaderboard->slice(-3,3);

        // Determine if the current user is not on the top or bottom
        if ($currentLeaderboardPosition < 3 || $currentLeaderboardPosition > (count($leaderboard) - 4)) {
            $currentLeaderboard = $leaderboard->slice(ceil(count($leaderboard) / 2), 3);
        } else {
            $currentLeaderboard = $leaderboard->slice($currentLeaderboardPosition - 1, 3);
        }

        $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::ORDINAL);
        $currentLeaderboardPosition = $numberFormatter->format($currentLeaderboardPosition + 1);

        return [$topLeaderboard, $currentLeaderboard, $lastLeaderboard, $currentLeaderboardPosition];
    }

    /**
     * Gets the current user or passed user position in a given leaderboard.
     * If no explicit user is passed then it attempts to get the current user.
     *
     * @param Collection $leaderboard
     * @param \App\User $user
     */
    private function getCurrentLeaderboardPosition(Collection $leaderboard, User $user = null): int
    {
        if (!isset($user) && \Auth::check()) {
            $user = \Auth::user();
        } elseif (!\Auth::check()) {
            return 0;
        }

        return $leaderboard->where('user_id', $user->id)->keys()->first();
    }
}
