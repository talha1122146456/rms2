<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Validate course data
     */
    protected function validateCourse(Request $request, $isUpdate = false)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor' => 'nullable|string|max:255',
            'duration' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        // Multiple file upload rules
        $fileRule = $isUpdate ? 'nullable' : 'required';
        $rules['files.*'] = $fileRule . '|file|mimes:pdf,mp4,webm,mkv,ogg|max:102400';

        return $request->validate($rules);
    }

    /**
     * Store uploaded files into database
     */
    protected function storeUploadedFiles($files, $courseId)
    {
        $records = [];

        foreach ($files as $file) {
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('courses', $filename, 'public');

            $ext = strtolower($file->getClientOriginalExtension());
            $type = $ext === 'pdf' ? 'pdf' : 'video';

            $records[] = [
                'course_id'  => $courseId,
                'file_name'  => $file->getClientOriginalName(),
                'file_path'  => $path,
                'file_type'  => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($records) {
            DB::table('course_files')->insert($records);
        }
    }

    /**
     * Store new course
     */
    public function store(Request $request)
    {
        $data = $this->validateCourse($request, false);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('course_images', 'public');
        }

        $course = Course::create($data);

        if ($request->hasFile('files')) {
            $this->storeUploadedFiles($request->file('files'), $course->id);
        }

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Show course details
     */
    public function show(Course $course)
    {
        $user = auth()->user();
    
        // Allow admins or enrolled users only
        if (!$user || ($user->role !== 'admin' && !$user->enrolledCourses->contains($course->id))) {
            return redirect()->route('courses.index1')
                ->with('error', 'You are not enrolled in this course.');
        }
    
        // Load related course files
        $course->load('files');
    
        return view('courses.show', compact('course'));
    }
    

    /**
     * Edit course form
     */
    public function edit(Course $course)
    {
        $course->load('files');
        return view('courses.edit', compact('course'));
    }

    /**
     * Update course
     */
    public function update(Request $request, Course $course)
    {
        $data = $this->validateCourse($request, true);

        if ($request->hasFile('image')) {
            if ($course->image && Storage::disk('public')->exists($course->image)) {
                Storage::disk('public')->delete($course->image);
            }
            $data['image'] = $request->file('image')->store('course_images', 'public');
        }

        $course->update($data);

        if ($request->hasFile('files')) {
            $this->storeUploadedFiles($request->file('files'), $course->id);
        }

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Delete course and its files
     */
    public function destroy(Course $course)
    {
        foreach ($course->files as $file) {
            if (Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }
        }

        if ($course->image && Storage::disk('public')->exists($course->image)) {
            Storage::disk('public')->delete($course->image);
        }

        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    /**
     * Main index (with search)
     */
    public function index(Request $request)
    {
        $query = trim($request->get('query', ''));

        $courses = Course::with('files')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('title', 'like', "%{$query}%")
                        ->orWhere('instructor', 'like', "%{$query}%");
                });
            })
            ->latest()
            ->paginate(9);

        $courses->appends(['query' => $query]);

        return view('courses.index', compact('courses'));
    }

    /**
     * AJAX live search endpoint
     */
    public function search(Request $request)
    {
        try {
            $query = trim($request->get('query', ''));
            $hideActions = $request->boolean('hideActions', false);

            $courses = Course::with('files')
                ->when($query, function ($q) use ($query) {
                    $q->where(function ($sub) use ($query) {
                        $sub->where('title', 'like', "%{$query}%")
                            ->orWhere('instructor', 'like', "%{$query}%");
                    });
                })
                ->latest()
                ->paginate(9);

            $courses->appends(['query' => $query]);

            $view = view('courses.partials.course_cards', [
                'courses' => $courses,
                'hideActions' => $hideActions,
            ])->render();

            return response()->json(['html' => $view]);
        } catch (\Throwable $e) {
            \Log::error('Course search error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Server error while searching courses.'
            ], 500);
        }
    }

    /**
     * Alternate index page (index1)
     */
    public function index1(Request $request)
    {
        $query = $request->get('query', '');

        $courses = Course::with('files')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('title', 'like', "%{$query}%")
                        ->orWhere('instructor', 'like', "%{$query}%");
                });
            })
            ->latest()
            ->paginate(9);

        $courses->appends(['query' => $query]);

        // Pass hideActions = true to hide all buttons (View/Edit/Delete)
        return view('courses.index1', compact('courses'))->with('hideActions', true);
    }
}
