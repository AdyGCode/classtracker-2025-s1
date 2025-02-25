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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('national_code');
            $table->string('aqf_level');
            $table->string('title');
            $table->string('tga_status');
            $table->string('state_code');
            $table->string('nominal_hours');
            $table->string('type');
            $table->string('qa');
            $table->string('nat_code');
            $table->string('nat_title');
            $table->string('nat_code_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
