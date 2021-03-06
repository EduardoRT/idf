<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Course;
use App\CourseEnrollment;
use Illuminate\Support\Facades\Cache;
use App\Leaderboard;
use Illuminate\Contracts\Support\Renderable;

class CourseEnrollmentController extends Controller
{
    public function show(string $slug): Renderable
    {
        $course = Course::where('slug', $slug)->first() ?? abort(404, 'Unknown course');

        [$topLeaderboard, $middleLeaderboard,
        $lastLeaderboard, $currentLeaderboardPosition, $shouldRenderLeaderboard] = Cache::remember('course.leaderboard.' . auth()->user()->id . 'global', 120, function() use ($course) {
            return Leaderboard::getCourseLeaderboard($course);
        });

        [$topGlobalLeaderboard, $middleGlobalLeaderboard,
        $lastGlobalLeaderboard, $currentGlobalLeaderboardPosition, $shouldRenderGlobalLeaderboard] = Cache::remember('course.leaderboard.'.auth()->user()->id.'country', 120, function() use ($course) {
            return Leaderboard::getCourseLeaderboard($course, 'country');
        });

        $enrollment = CourseEnrollment::where('course_id', $course->id)
            ->where('user_id', auth()->id())
            ->first() ?? abort(404, 'You are not enrolled to this course');

        $userScore = Cache::remember('course.leaderboard'.auth()->user()->id.'score', 120, function() use ($course) {
            return  Leaderboard::where('course_id', $course->id)
                ->where('user_id', auth()->id())
                ->get()
                ->first();
        });

        if (isset($userScore)) {
            $userScore = $userScore->total_score;
        } else {
            $userScore = 0;
        }

        return view('courseEnrollment', [
            'enrollment' => $enrollment,
            'topLeaderboard' => $topLeaderboard,
            'middleLeaderboard' => $middleLeaderboard,
            'lastLeaderboard' => $lastLeaderboard,
            'userScore' => $userScore,
            'currentLeaderboardPosition' => $currentLeaderboardPosition,
            'topGlobalLeaderboard' => $topGlobalLeaderboard,
            'middleGlobalLeaderboard' => $middleGlobalLeaderboard,
            'lastGlobalLeaderboard' => $lastGlobalLeaderboard,
            'currentGlobalLeaderboardPosition' => $currentGlobalLeaderboardPosition,
            'shouldRenderLeaderboard' => $shouldRenderLeaderboard,
            'shouldRenderGlobalLeaderboard' => $shouldRenderGlobalLeaderboard,
        ]);
    }
}
