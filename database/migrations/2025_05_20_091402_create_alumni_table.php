SELECT email, profile_completed FROM users WHERE email = 'your_test_user_email';<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->increments('alumniID');
            $table->string('alumniName');
            $table->string('alumniEmail')->unique();
            $table->string('alumniPhone');
            $table->string('alumniFaculty');
            $table->text('alumniResume')->nullable();
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
