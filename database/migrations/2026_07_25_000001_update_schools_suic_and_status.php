<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Rename pincode → suic_code and replace the status enum with:
     *   registered | under_construction | trial_running | on_going
     */
    public function up(): void
    {
        // Step 1: Rename pincode column to suic_code and widen it
        Schema::table('schools', function (Blueprint $table) {
            $table->renameColumn('pincode', 'suic_code');
        });

        Schema::table('schools', function (Blueprint $table) {
            $table->char('suic_code', 6)->unique()->change();
        });

        // Step 2: Drop the old enum and add the new one.
        // MySQL requires dropping and re-adding or using a raw ALTER for enum changes.
        DB::statement("ALTER TABLE schools MODIFY COLUMN status ENUM('registered','under_construction','trial_running','on_going') NOT NULL DEFAULT 'registered'");

        // Step 3: Set any existing rows that had old values to 'registered'
        DB::statement("UPDATE schools SET status = 'registered' WHERE status NOT IN ('registered','under_construction','trial_running','on_going')");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE schools MODIFY COLUMN status ENUM('pending','approved','under_review','rejected') NOT NULL DEFAULT 'pending'");

        DB::statement("UPDATE schools SET status = 'pending' WHERE status NOT IN ('pending','approved','under_review','rejected')");

        Schema::table('schools', function (Blueprint $table) {
            $table->string('suic_code', 10)->change();
        });

        Schema::table('schools', function (Blueprint $table) {
            $table->renameColumn('suic_code', 'pincode');
        });
    }
};
