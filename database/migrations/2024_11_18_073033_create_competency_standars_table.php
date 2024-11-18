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
        Schema::create('competency_standars', function (Blueprint $table) {
            $table->id();
            $table->string('unit_code', 32);
            $table->string('unit_title', 64);
            $table->longText('unit_description')->nullable();
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade');
            $table->foreignId('assessor_id')->constrained('assessors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competency_standars');
    }
};
