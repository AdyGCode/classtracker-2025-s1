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
        Schema::create('clusters', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('title');
            $table->string('qualification');
            $table->string('qualification_code');
            $table->string('unit_1')->nullable();
            $table->string('unit_2')->nullable();
            $table->string('unit_3')->nullable();
            $table->string('unit_4')->nullable();
            $table->string('unit_5')->nullable();
            $table->string('unit_6')->nullable();
            $table->string('unit_7')->nullable();
            $table->string('unit_8')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clusters');
    }
};
