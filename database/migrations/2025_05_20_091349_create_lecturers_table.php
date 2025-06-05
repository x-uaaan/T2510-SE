<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lecturers', function (Blueprint $table) {
            $table->increments('lecturerID');
            $table->string('lecturerName');
            $table->string('lecturerPhone');
            $table->string('lecturerEmail')->unique();
            $table->string('lecturerFaculty');
            $table->timestamps();
        });     
    }

    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};
