<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->increments('attendeesID');
            $table->foreignId('eventID')->constrained('events')->onDelete('cascade');
            $table->foreignId('alumniID')->constrained('alumni')->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('attendees');
    }
};
