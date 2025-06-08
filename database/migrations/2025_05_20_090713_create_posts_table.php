<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('postID');
            $table->string('postTitle');
            $table->text('postDesc');
            $table->text('comment')->nullable();
            $table->timestamp('timestamp');
            $table->unsignedInteger('forumID');
            $table->foreign('forumID')->references('forumID')->on('forums')->onDelete('cascade');
            $table->unsignedInteger('alumniID');
            $table->foreign('alumniID')->references('alumniID')->on('alumni')->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
