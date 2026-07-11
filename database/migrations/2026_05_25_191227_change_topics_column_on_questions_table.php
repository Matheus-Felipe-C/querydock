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
        // 1. Drop the old column first
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('topic');
        });

        // 2. Add the new column in a fresh closure
        Schema::table('questions', function (Blueprint $table) {
            $table->json('topics')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('topics');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->string('topic')->nullable();
        });
    }
};