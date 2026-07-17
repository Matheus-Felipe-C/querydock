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
    if (Schema::hasColumn('questions', 'topic')) {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('topic');
        });
    }

    if (! Schema::hasColumn('questions', 'topics')) {
        Schema::table('questions', function (Blueprint $table) {
            $table->json('topics')->nullable();
        });
    }
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    if (Schema::hasColumn('questions', 'topics')) {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('topics');
        });
    }

    if (! Schema::hasColumn('questions', 'topic')) {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('topic')->nullable();
        });
    }
}
};