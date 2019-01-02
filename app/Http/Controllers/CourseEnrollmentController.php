<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Course;
use App\CourseEnrollment;
use App\Leaderboard;
use Illuminate\Contracts\Support\Renderable;

class CourseEnrollmentController extends Controller
{
    public function show(string $slug): Renderable
    {
        $course = Course::where('slug', $slug)->first() ?? abort(404, 'Unknown course');

        [$topLeaderboard, $middleLeaderboard,
        $lastLeaderboard, $currentLeaderboardPosition, $shouldRenderLeaderboard] = Leaderboard::getCourseLeaderboard($course);

        [$topGlobalLeaderboard, $middleGlobalLeaderboard,
        $lastGlobalLeaderboard, $currentGlobalLeaderboardPosition, $shouldRenderGlobalLeaderboard] = Leaderboard::getCourseLeaderboard($course, 'country');

        $enrollment = CourseEnrollment::where('course_id', $course->id)
            ->where('user_id', auth()->id())
            ->first() ?? abort(404, 'You are not enrolled to this course');

        $userScore = Leaderboard::where('course_id', $course->id)
            ->where('user_id', auth()->id())
            ->get()
            ->first();


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
