<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user();
        $classSection = $student->classSection;
        
        // Load subjects if class exists to display them on the dashboard
        if ($classSection) {
            $classSection->load(['subjects', 'academicSession']);
        }

        return view('student.dashboard', compact('student', 'classSection'));
    }

    public function showResults($classSectionId) {
        // Placeholder for detailed results view if needed in future
        return redirect()->route('student.dashboard');
    }
}