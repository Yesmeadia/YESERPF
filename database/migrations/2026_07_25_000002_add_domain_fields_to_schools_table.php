<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds two nullable domain columns to the schools table:
     * - existing_domain: the school's currently running website/domain
     * - desired_domain:  a new domain the school wishes to register
     */
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('existing_domain', 255)->nullable()->after('suic_code')
                  ->comment('URL of the school\'s currently running domain (if they have one)');
            $table->string('desired_domain', 255)->nullable()->after('existing_domain')
                  ->comment('Domain name the school wants to register (if they don\'t have one)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['existing_domain', 'desired_domain']);
        });
    }
};
