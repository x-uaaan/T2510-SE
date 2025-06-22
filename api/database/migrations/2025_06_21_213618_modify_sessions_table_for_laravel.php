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
        Schema::table('sessions', function (Blueprint $table) {
            // First, drop the foreign key constraint if it exists
            $table->dropForeign(['userID']);
            
            // Rename columns to match Laravel's expectations
            $table->renameColumn('sessionsID', 'id');
            $table->renameColumn('userID', 'user_id');
        });
        
        // Now add the foreign key with the correct reference
        Schema::table('sessions', function (Blueprint $table) {
            // Make user_id nullable and add index
            $table->string('user_id', 255)->nullable()->change();
            $table->index('user_id');
            
            // Add foreign key constraint to users table
            $table->foreign('user_id')->references('userID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
            
            // Rename columns back to original names
            $table->renameColumn('id', 'sessionsID');
            $table->renameColumn('user_id', 'userID');
            
            // Restore original foreign key
            $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade');
        });
    }
};
