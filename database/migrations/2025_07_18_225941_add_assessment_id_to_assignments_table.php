<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssessmentIdToAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // The code is now restored for future migrations.
        Schema::table('assignments', function (Blueprint $table) {
            $table->foreignId('assessment_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeign(['assessment_id']);
            $table->dropColumn('assessment_id');
        });
    }
}