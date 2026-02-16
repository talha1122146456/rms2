<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * ✅ Enroll the logged-in user into a course
     */
    public function store(Course $course)
    {
        $user = auth()->user();

        // 🔒 Redirect if not logged in
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Please log in to enroll in a course.');
        }

        // 🧭 Check if already enrolled
        if ($user->enrolledCourses->contains($course->id)) {
            return back()->with('info', 'You are already enrolled in this course.');
        }

        // 📝 Create new enrollment record
        Enrollment::create([
            'user_id'   => $user->id,
            'course_id' => $course->id,
        ]);

        return back()->with('success', '🎉 You have successfully enrolled in this course!');
    }

    /**
     * ✅ Display all courses the logged-in user is enrolled in
     */
    public function myCourses(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Please log in to view your enrolled courses.');
        }

        $query = trim($request->get('query', ''));

        // 📚 Fetch enrolled courses with related files
        $courses = $user->enrolledCourses()
            ->with('files')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('title', 'like', "%{$query}%")
                        ->orWhere('instructor', 'like', "%{$query}%");
                });
            })
            ->latest()
            ->paginate(9);

        $courses->appends(['query' => $query]);

        return view('courses.my', compact('courses'));
    }

    /**
     * ✅ AJAX: Live search through user's enrolled courses
     */
    public function searchMy(Request $request)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $query = trim($request->get('query', ''));

            $courses = $user->enrolledCourses()
                ->with('files')
                ->when($query, function ($q) use ($query) {
                    $q->where(function ($sub) use ($query) {
                        $sub->where('title', 'like', "%{$query}%")
                            ->orWhere('instructor', 'like', "%{$query}%");
                    });
                })
                ->latest()
                ->paginate(9);

            $courses->appends(['query' => $query]);

            $html = view('courses.partials.my_courses_list', compact('courses'))->render();

            return response()->json(['html' => $html]);
        } catch (\Throwable $e) {
            \Log::error('Enrollment search error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error while searching courses.'], 500);
        }
    }
}
