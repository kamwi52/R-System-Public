<?php

namespace App\Http\Controllers;

use App\Models\ClassSection;
use App\Models\AcademicSession;
use App\Models\User;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Eager load academic session and count students for the dashboard list
        $query = ClassSection::with('academicSession')->withCount('students');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $classes = $query->orderBy('name')->get();

        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        $academicSessions = AcademicSession::all();
        return view('classes.create', compact('academicSessions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'academic_session_id' => 'required|exists:academic_sessions,id',
        ]);

        ClassSection::create($request->all());

        return redirect('/classes')->with('success', 'Class created successfully.');
    }

    public function edit($id)
    {
        $classSection = ClassSection::findOrFail($id);
        $academicSessions = AcademicSession::all();
        return view('classes.edit', compact('classSection', 'academicSessions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'academic_session_id' => 'required|exists:academic_sessions,id',
        ]);

        $classSection = ClassSection::findOrFail($id);
        $classSection->update($request->all());

        return redirect('/classes')->with('success', 'Class updated successfully.');
    }

    public function destroy($id)
    {
        $classSection = ClassSection::findOrFail($id);
        $classSection->delete();

        return redirect('/classes')->with('success', 'Class deleted successfully.');
    }

    public function students($id)
    {
        $classSection = ClassSection::with('students')->findOrFail($id);
        return view('classes.students', compact('classSection'));
    }

    public function enroll($id)
    {
        $classSection = ClassSection::findOrFail($id);
        // Find students who do not have a class_section_id (not enrolled anywhere)
        $availableStudents = User::where('role', 'student')
            ->whereNull('class_section_id')
            ->orderBy('name')
            ->get();

        return view('classes.enroll', compact('classSection', 'availableStudents'));
    }

    public function storeEnrollment(Request $request, $id)
    {
        $request->validate(['student_id' => 'required|exists:users,id']);
        $student = User::findOrFail($request->student_id);
        $student->update(['class_section_id' => $id]);
        return redirect()->route('classes.students', $id)->with('success', 'Student enrolled successfully.');
    }

    public function removeStudent($classId, $studentId)
    {
        User::where('id', $studentId)->where('class_section_id', $classId)->update(['class_section_id' => null]);
        return redirect()->back()->with('success', 'Student removed from class.');
    }
}