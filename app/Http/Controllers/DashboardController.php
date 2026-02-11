<?php

namespace App\Http\Controllers;

use App\Models\ClassSection;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $counts = [];

        if ($user->role === 'admin') {
            $counts['users'] = User::count();
            $counts['students'] = User::where('role', 'student')->count();
            $counts['teachers'] = User::where('role', 'teacher')->count();
            $counts['classes'] = ClassSection::count();
            $counts['subjects'] = Subject::count();
        }

        return view('dashboard', compact('user', 'counts'));
    }
}