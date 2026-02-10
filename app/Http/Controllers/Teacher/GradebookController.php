<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassSection;
use App\Models\Subject;
use App\Models\Assessment;
use App\Models\Result;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class GradebookController extends Controller
{
    /**
     * Show the list of assessments (e.g., Mid-Term, Final) for a specific class and subject.
     */
    public function showAssessments($classSectionId, $subjectId)
    {
        $classSection = ClassSection::findOrFail($classSectionId);
        $subject = Subject::findOrFail($subjectId);

        // Fetch assessments linked to this subject (assuming assessments are defined globally per subject or session)
        // In many systems, assessments are filtered by Academic Session as well.
        // For this overhaul, we'll fetch assessments that belong to this subject.
        $assessments = Assessment::where('subject_id', $subjectId)
            ->withCount(['results as graded_count' => function($query) use ($classSectionId) {
                $query->whereHas('student', function($q) use ($classSectionId) {
                    $q->where('class_section_id', $classSectionId);
                });
            }])
            ->get();

        return view('teacher.gradebook.assessments', compact('classSection', 'subject', 'assessments'));
    }

    public function findAndEditLatestAssessment($classSectionId, $subjectId)
    {
        // Redirect to the main assessment list for now
        return redirect()->route('teacher.gradebook.assessments', [$classSectionId, $subjectId]);
    }

    public function showResults(Assessment $assessment)
    {
        // Load the class section and students associated with this assessment
        $classSection = $assessment->classSection;
        $students = $classSection->students()->orderBy('name')->get();
        
        // Fetch existing results for this assessment keyed by student_id for easy lookup
        $results = Result::where('assessment_id', $assessment->id)
                    ->get()
                    ->keyBy('student_id');

        return view('teacher.gradebook.results', compact('assessment', 'students', 'results', 'classSection'));
    }

    public function storeResults(Request $request, Assessment $assessment)
    {
        $request->validate([
            'scores' => 'array',
            'scores.*' => 'nullable|numeric|min:0|max:' . ($assessment->max_score ?? 100),
        ]);

        foreach ($request->scores as $studentId => $score) {
            // Update or create the result record
            Result::updateOrCreate(
                [
                    'assessment_id' => $assessment->id,
                    'student_id' => $studentId,
                ],
                ['score' => $score]
            );
        }

        return redirect()->route('teacher.gradebook.results', $assessment->id)
            ->with('success', 'Grades saved successfully.');
    }

    public function printSummary(Assessment $assessment)
    {
        $classSection = $assessment->classSection;
        $students = $classSection->students()->orderBy('name')->get();
        $results = Result::where('assessment_id', $assessment->id)->get()->keyBy('student_id');

        $pdf = Pdf::loadView('pdf.assessment-summary', compact('assessment', 'classSection', 'students', 'results'));
        return $pdf->stream('assessment-summary-' . $assessment->id . '.pdf');
    }
}