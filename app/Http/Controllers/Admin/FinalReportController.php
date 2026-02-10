<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\ClassSection;
use App\Models\Term;
use App\Models\User;
use App\Models\Result;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FinalReportController extends Controller
{
    public function index()
    {
        $sessions = AcademicSession::orderBy('start_date', 'desc')->get();
        $classes = ClassSection::orderBy('name')->get();
        $terms = Term::all();

        return view('admin.reports.index', compact('sessions', 'classes', 'terms'));
    }

    public function showStudents(Request $request)
    {
        $request->validate([
            'academic_session_id' => 'required',
            'class_section_id' => 'required',
            'term_id' => 'required',
        ]);

        $classSection = ClassSection::findOrFail($request->class_section_id);
        $session = AcademicSession::findOrFail($request->academic_session_id);
        $term = Term::findOrFail($request->term_id);

        // Get students in this class
        $students = User::where('class_section_id', $classSection->id)
                        ->where('role', 'student')
                        ->orderBy('name')
                        ->get();

        return view('admin.reports.students', compact('students', 'classSection', 'session', 'term'));
    }

    private function getReportData($student, $classSection, $term)
    {
        $subjects = $classSection->subjects;
        $reportData = [];

        foreach($subjects as $subject) {
            // Get assessments for this subject, term, and class
            $assessments = Assessment::where('subject_id', $subject->id)
                            ->where('class_section_id', $classSection->id)
                            ->where('term_id', $term->id)
                            ->get();

            $subjectTotal = 0;
            $subjectMax = 0;
            $assessmentDetails = [];

            foreach($assessments as $assessment) {
                $result = Result::where('assessment_id', $assessment->id)
                                ->where('student_id', $student->id)
                                ->first();
                
                $score = $result ? $result->score : 0;
                // Only count max marks if the student was actually graded or if we assume 0 for missing
                // For this report, we sum up max marks of all assessments defined for the class
                $subjectTotal += $score;
                $subjectMax += $assessment->max_marks;

                $assessmentDetails[] = [
                    'name' => $assessment->name,
                    'score' => $score,
                    'max' => $assessment->max_marks
                ];
            }

            $percentage = $subjectMax > 0 ? ($subjectTotal / $subjectMax) * 100 : 0;
            $grade = $this->calculateGrade($percentage);

            $reportData[] = [
                'subject' => $subject->name,
                'code' => $subject->code,
                'assessments' => $assessmentDetails,
                'total_score' => $subjectTotal,
                'max_score' => $subjectMax,
                'percentage' => $percentage,
                'grade' => $grade
            ];
        }

        return $reportData;
    }

    public function generateSingle($studentId, $classId, $termId)
    {
        $student = User::findOrFail($studentId);
        $classSection = ClassSection::with('subjects')->findOrFail($classId);
        $term = Term::findOrFail($termId);
        
        // We use the class's session or the one passed implicitly via context. 
        // For the report card, we usually display the session linked to the class.
        $session = $classSection->academicSession; 

        $reportData = $this->getReportData($student, $classSection, $term);

        $pdf = Pdf::loadView('pdf.report-card', compact('student', 'classSection', 'term', 'reportData', 'session'));
        return $pdf->stream('ReportCard_' . $student->name . '_' . $term->name . '.pdf');
    }

    private function calculateGrade($percentage)
    {
        // Basic grading logic - this could be replaced by a database lookup
        if ($percentage >= 90) return 'A+';
        if ($percentage >= 80) return 'A';
        if ($percentage >= 70) return 'B';
        if ($percentage >= 60) return 'C';
        if ($percentage >= 50) return 'D';
        return 'F';
    }
    
    public function generate(Request $request) {
        $request->validate([
            'academic_session_id' => 'required',
            'class_section_id' => 'required',
            'term_id' => 'required',
        ]);

        if (!class_exists('ZipArchive')) {
            return redirect()->back()->with('error', 'ZipArchive extension is not installed on the server.');
        }

        $classSection = ClassSection::with('subjects')->findOrFail($request->class_section_id);
        $session = AcademicSession::findOrFail($request->academic_session_id);
        $term = Term::findOrFail($request->term_id);

        $students = User::where('class_section_id', $classSection->id)
                        ->where('role', 'student')
                        ->get();

        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'No students found to generate reports.');
        }

        $zipFileName = 'reports_' . \Str::slug($classSection->name) . '_' . \Str::slug($term->name) . '_' . time() . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);
        
        // Ensure directory exists
        if (!file_exists(dirname($zipFilePath))) {
            mkdir(dirname($zipFilePath), 0755, true);
        }

        $zip = new \ZipArchive;
        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            foreach ($students as $student) {
                $reportData = $this->getReportData($student, $classSection, $term);
                $pdf = Pdf::loadView('pdf.report-card', compact('student', 'classSection', 'term', 'reportData', 'session'));
                $content = $pdf->output();
                $fileName = \Str::slug($student->name) . '_' . $student->id . '.pdf';
                $zip->addFromString($fileName, $content);
            }
            $zip->close();
        } else {
             return redirect()->back()->with('error', 'Could not create ZIP file.');
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
}