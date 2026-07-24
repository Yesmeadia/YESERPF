<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->foreignId('state_id')->constrained('states')->onDelete('restrict');
            $table->foreignId('zone_id')->constrained('zones')->onDelete('restrict');
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->string('principal_name');
            $table->string('email');
            $table->string('phone', 20);
            $table->text('address');
            $table->string('pincode', 10);
            $table->integer('total_students')->default(0);
            $table->integer('total_teachers')->default(0);
            $table->enum('status', ['pending', 'approved', 'rejected', 'under_review'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for high performance over 10,000+ school records
            $table->index(['status', 'state_id']);
            $table->index(['status', 'zone_id']);
            $table->index(['status', 'category_id']);
            $table->index('created_at');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
