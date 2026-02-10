<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ClassSection;
use App\Models\Subject;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalClasses = ClassSection::count();
        $totalSubjects = Subject::count();

        return view('admin.dashboard', compact('totalStudents', 'totalTeachers', 'totalClasses', 'totalSubjects'));
    }
}