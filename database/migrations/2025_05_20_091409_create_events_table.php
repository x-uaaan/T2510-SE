<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id('eventID')->primary();
            $table->string('eventName');
            $table->text('eventDesc');
            $table->date('eventDate');
            $table->time('eventTime');
            $table->string('eventVenue');
            $table->foreignId('adminID')->constrained('admins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
