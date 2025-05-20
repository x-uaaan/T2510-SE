<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id('adminID');
            $table->string('adminName');
            $table->string('adminPassword');
            $table->string('adminEmail')->unique();
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
