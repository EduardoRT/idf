<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Course;
use App\CourseEnrollment;
use Illuminate\Contracts\Support\Renderable;

class CourseEnrollmentController extends Controller
{
    public function show(string $slug): Renderable
    {
        $course = Course::where('slug', $slug)->first() ?? abort(404, 'Unknown course');
        $enrollment = CourseEnrollment::where('course_id', $course->id)
            ->where('user_id', auth()->id())
            ->first() ?? abort(404, 'You are not enrolled to this course');

        return view('courseEnrollment', [
            'enrollment' => $enrollment,
        ]);
    }
}
