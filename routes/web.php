<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\DatabaseNotification;

// Import all controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportCardController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController as MainDashboardController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportingController;
use App\Http\Controllers\Admin\FinalReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ClassSectionController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\AssessmentController;
use App\Http\Controllers\Admin\ResultController as AdminResultController;
use App\Http\Controllers\Admin\GradingScaleController;
use App\Http\Controllers\Admin\AcademicSessionController;
use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Admin\PromotionController;

// Teacher Controllers
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\BulkGradeController;
use App\Http\Controllers\Teacher\GradebookController;
use App\Http\Controllers\Teacher\ResultController as TeacherResultController;
use App\Http\Controllers\Teacher\AssignmentController;
use App\Http\Controllers\Teacher\ReportCardController as TeacherReportCardController;

// Student Controllers
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check() ? redirect()->route('home') : view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [MainDashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/notifications/{notification}', function (DatabaseNotification $notification) {
        abort_if($notification->notifiable_id != auth()->id(), 403);
        $notification->markAsRead();
        if (isset($notification->data['action_url']) && $notification->data['action_url']) {
            return redirect($notification->data['action_url']);
        }
        return redirect()->back();
    })->name('notifications.show');

    Route::get('/reports/download-generated-file', [ReportingController::class, 'downloadGeneratedFile'])->name('reports.download.generated');

});

// Fix for 404 on /classes: Redirect to the correct admin route
Route::middleware(['auth'])->get('/classes', function () {
    return redirect()->route('admin.classes.index');
});

// Admin Routes
Route::middleware(['auth', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {
    // === FIX: The admin dashboard route now points to the new DashboardController ===
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Shared Class Management Routes

    // User Management
    Route::get('/users/import', [UserController::class, 'showImportForm'])->name('users.import.show');
    Route::post('/users/import', [UserController::class, 'handleImport'])->name('users.import.handle');
    Route::delete('/users/bulk-destroy', [UserController::class, 'bulkDestroy'])->name('users.bulk-destroy');
    Route::resource('users', UserController::class);

    // Subject Management
    Route::resource('subjects', SubjectController::class);

    // Class Management
    Route::get('/classes/{classSection}/subjects', [ClassSectionController::class, 'getSubjectsJson'])->name('classes.subjects.json');
    Route::get('/classes/import', [ClassSectionController::class, 'showImportForm'])->name('classes.import.show');
    Route::post('/classes/import', [ClassSectionController::class, 'handleImport'])->name('classes.import.handle');
    Route::get('/classes/{classSection}/assign-teachers', [ClassSectionController::class, 'assignTeachers'])->name('classes.teachers.assign');
    Route::post('/classes/{classSection}/assign-teachers', [ClassSectionController::class, 'storeTeacherAssignments'])->name('classes.teachers.store');
    Route::resource('classes', ClassSectionController::class)->parameters(['classes' => 'classSection']);

    // Enrollment Management
    Route::get('/enrollments/bulk-manage', [EnrollmentController::class, 'showBulkManageForm'])->name('enrollments.bulk-manage.show');
    Route::post('/enrollments/bulk-save', [EnrollmentController::class, 'handleBulkManage'])->name('enrollments.bulk-manage.handle');
    Route::get('classes/{classSection}/enroll', [EnrollmentController::class, 'index'])->name('classes.enroll.index');
    Route::post('classes/{classSection}/enroll', [EnrollmentController::class, 'store'])->name('classes.enroll.store');

    // Assessment Management
    Route::get('assessments/bulk-create', [AssessmentController::class, 'showBulkCreateForm'])->name('assessments.bulk-create.show');
    Route::post('assessments/bulk-create', [AssessmentController::class, 'handleBulkCreate'])->name('assessments.bulk-create.handle');
    Route::resource('assessments', AssessmentController::class);
    Route::get('results/import', [AdminResultController::class, 'showImportForm'])->name('results.import.show');
    Route::post('results/import', [AdminResultController::class, 'handleImport'])->name('results.import.handle');
    Route::resource('results', AdminResultController::class);

    // Settings Management
    Route::resource('grading-scales', GradingScaleController::class);
    Route::resource('academic-sessions', AcademicSessionController::class);
    Route::resource('terms', TermController::class);

    // Reporting Management
    Route::get('/reporting', [ReportingController::class, 'index'])->name('reporting.index');

    Route::prefix('final-reports')->name('final-reports.')->group(function() {
        Route::get('/', [FinalReportController::class, 'index'])->name('index');
        Route::get('/show-students', [FinalReportController::class, 'showStudents'])->name('show-students');
        Route::post('/generate', [FinalReportController::class, 'generate'])->name('generate');
        Route::get('/generate-single/{student_id}/{class_id}/{term_id}', [FinalReportController::class, 'generateSingle'])->name('generate-single');
    });

    // Promotion Management
    Route::prefix('promotions')->name('promotions.')->group(function() {
        Route::get('/', [PromotionController::class, 'index'])->name('index');
        Route::get('/get-students', [PromotionController::class, 'getStudents'])->name('get-students');
        Route::post('/promote', [PromotionController::class, 'promote'])->name('promote');
    });
});
// Teacher Routes
Route::middleware(['auth', 'is.teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
    
    // New Streamlined Gradebook Workflow
    Route::get('/gradebook/{classSection}/{subject}/edit', [GradebookController::class, 'findAndEditLatestAssessment'])->name('gradebook.find-and-edit');

    Route::get('/gradebook/{assessment}/results', [GradebookController::class, 'showResults'])->name('gradebook.results');
    Route::post('/gradebook/{assessment}/results', [GradebookController::class, 'storeResults'])->name('gradebook.results.store');
    
    // Other Gradebook Features
    Route::get('/gradebook/{classSection}/{subject}', [GradebookController::class, 'showAssessments'])->name('gradebook.assessments');
    Route::post('/gradebook/{assessment}/results/import', [GradebookController::class, 'handleResultsImport'])->name('gradebook.results.import');
    Route::get('/gradebook/{assessment}/summary/print', [GradebookController::class, 'printSummary'])->name('gradebook.summary.print');

    // Bulk Grading
    Route::get('/bulk-grades', [BulkGradeController::class, 'index'])->name('bulk-grades.index');
    Route::post('/bulk-grades', [BulkGradeController::class, 'store'])->name('bulk-grades.store');

    // Assignments
    Route::resource('assignments', AssignmentController::class);

    // Results Management
    Route::resource('results', TeacherResultController::class);

    // Report Cards
    Route::get('/report-cards', [TeacherReportCardController::class, 'index'])->name('report-cards.index');
    Route::get('/report-cards/{student}', [TeacherReportCardController::class, 'show'])->name('report-cards.show');
});

// Student Routes
Route::middleware(['auth', 'is.student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/classes/{classSection}/results', [StudentDashboardController::class, 'showResults'])->name('class.results');
    Route::get('/my-report', [ReportCardController::class, 'generateForStudent'])->name('my.report');
});


require __DIR__.'/auth.php';