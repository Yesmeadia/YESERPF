<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add disaggregated student and staff columns to schools table.
     * These replace the generic total_students / total_teachers fields
     * with gender-wise and role-wise breakdowns required for ERP reporting.
     */
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            // --- Students ---
            $table->unsignedInteger('male_students')->default(0)->after('pincode');
            $table->unsignedInteger('female_students')->default(0)->after('male_students');

            // --- Teaching Staff ---
            $table->unsignedInteger('teaching_male_staff')->default(0)->after('female_students');
            $table->unsignedInteger('teaching_female_staff')->default(0)->after('teaching_male_staff');

            // --- Non-Teaching Staff ---
            $table->unsignedInteger('non_teaching_male_staff')->default(0)->after('teaching_female_staff');
            $table->unsignedInteger('non_teaching_female_staff')->default(0)->after('non_teaching_male_staff');
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn([
                'male_students', 'female_students',
                'teaching_male_staff', 'teaching_female_staff',
                'non_teaching_male_staff', 'non_teaching_female_staff',
            ]);
        });
    }
};
