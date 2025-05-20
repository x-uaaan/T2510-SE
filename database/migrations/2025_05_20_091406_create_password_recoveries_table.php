<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('password_recovery', function (Blueprint $table) {
            $table->id('recoveryID');
            $table->foreignId('alumniID')->constrained('alumni')->onDelete('cascade');
            $table->string('OTP');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('password_recoveries');
    }
};
