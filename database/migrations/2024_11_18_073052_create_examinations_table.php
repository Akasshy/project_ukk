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
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->dateTime('exam_date');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('assessor_id')->constrained('assessors')->onDelete('cascade');
            $table->foreignId('standar_id')->constrained('competency_standars')->onDelete('cascade');
            $table->foreignId('element_id')->constrained('competency_elements')->onDelete('cascade');
            $table->tinyInteger('status')->default(0);
            $table->longText('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};
