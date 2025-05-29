<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('eventName');
            $table->text('eventDesc');
            $table->date('eventDate');
            $table->time('eventTime');
            $table->string('eventVenue');
            $table->integer('capacity')->nullable(); // NULL for unlimited capacity
            $table->string('organiser');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
