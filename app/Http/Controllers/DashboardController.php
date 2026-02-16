<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{






    public function write()
    {
        return view('about');
    }













    public function index()
    {
        $user = Auth::user();

        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();
        $myCoursesCount = Enrollment::where('user_id', $user->id)->count();

        $recentCourses = Course::latest()->take(6)->get();

        // Group enrollments by month for chart
        $enrollmentsPerMonth = Enrollment::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Prepare chart labels and data
        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
            9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];

        $chartLabels = [];
        $chartData = [];

        foreach ($months as $num => $name) {
            $chartLabels[] = $name;
            $chartData[] = $enrollmentsPerMonth->firstWhere('month', $num)->total ?? 0;
        }

        return view('dashboard', compact(
            'user',
            'totalCourses',
            'totalEnrollments',
            'myCoursesCount',
            'recentCourses',
            'chartLabels',
            'chartData'
        ));
    }
}
