<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassSection;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        // Fetch classes where the teacher has at least one subject assigned.
        // We also eager load only the subjects assigned to this teacher.
        $assignedClasses = ClassSection::whereHas('subjects', function($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->with(['subjects' => function($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        }, 'academicSession', 'students'])->get();

        return view('teacher.dashboard', compact('assignedClasses'));
    }
}