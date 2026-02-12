<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AcademicSession;
use App\Models\ClassSection;
use App\Models\Subject;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Academic Session
        // We use firstOrCreate to prevent duplicates if seeded multiple times
        $session = AcademicSession::firstOrCreate(
            ['name' => '2024-2025'],
            // Add start_date/end_date here if your model requires them
        );

        // 2. Create Subjects
        $subjects = [
            ['name' => 'Mathematics', 'code' => 'MTH101'],
            ['name' => 'English Language', 'code' => 'ENG101'],
            ['name' => 'Basic Science', 'code' => 'SCI101'],
            ['name' => 'Social Studies', 'code' => 'SOC101'],
        ];

        foreach ($subjects as $subjectData) {
            Subject::firstOrCreate(
                ['code' => $subjectData['code']],
                ['name' => $subjectData['name']]
            );
        }

        // 3. Create Users (Admin, Teacher, Student)
        
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@lssms.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'), // Default password
                'role' => 'admin',
            ]
        );

        // Teacher
        $teacher = User::firstOrCreate(
            ['email' => 'teacher@lssms.com'],
            [
                'name' => 'Sarah Teacher',
                'password' => Hash::make('password'),
                'role' => 'teacher',
            ]
        );

        // Student
        $student = User::firstOrCreate(
            ['email' => 'student@lssms.com'],
            [
                'name' => 'John Student',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );

        // 4. Create a Class Section
        $classSection = ClassSection::firstOrCreate(
            ['name' => 'JSS 1A'],
            ['academic_session_id' => $session->id]
        );

        // 5. Enroll Student in Class
        if (is_null($student->class_section_id)) {
            $student->update(['class_section_id' => $classSection->id]);
        }

        // 6. Assign Subjects to Class (with Teacher)
        $math = Subject::where('code', 'MTH101')->first();
        
        // Check if subject is already assigned to avoid errors
        if ($math && !$classSection->subjects()->where('subject_id', $math->id)->exists()) {
            $classSection->subjects()->attach($math->id, ['teacher_id' => $teacher->id]);
        }
    }
}