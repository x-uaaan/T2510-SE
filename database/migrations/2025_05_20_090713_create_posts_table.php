<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id('postID')->primary();
            $table->string('postTitle');
            $table->text('postDesc');
            $table->text('comment')->nullable();
            $table->timestamp('timestamp');
            $table->foreignId('forumID')->constrained('forums')->onDelete('cascade');
            $table->foreignId('alumniID')->constrained('alumni')->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
