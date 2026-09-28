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
        Schema::table('submissions', function (Blueprint $table) {
            $table->string('status')->default('in_progress')->change();
        });

        DB::table('submissions')
            ->where('status', 'in progress')
            ->update(['status' => 'in_progress']);

        DB::table('submissions')
            ->whereNull('started_at')
            ->update(['started_at' => DB::raw('created_at')]);

        Schema::table('submissions', function (Blueprint $table) {
            $table->timestamp('started_at')->useCurrent()->change();
            $table->decimal('score', 5, 2)->nullable()->change();
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->unsignedSmallInteger('attempt_number')->default(1);
            $table->decimal('auto_score', 5, 2)->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('graded_at')->nullable();
            $table->unique(['quiz_id', 'user_id', 'attempt_number']);
            $table->index(['quiz_id', 'status']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropUnique(['quiz_id', 'user_id', 'attempt_number']);
            $table->dropIndex(['submissions_quiz_id_status_index']);
            $table->dropForeign(['graded_by']);
            $table->dropColumn(['attempt_number', 'auto_score', 'graded_by', 'graded_at']);
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->timestamp('started_at')->nullable()->change();
            $table->unsignedTinyInteger('score')->nullable()->change();
        });

        DB::table('submissions')
            ->where('status', 'in_progress')
            ->update(['status' => 'in progress']);

        Schema::table('submissions', function (Blueprint $table) {
            $table->enum('status', ['in progress', 'completed'])
                ->default('in progress')
                ->change();
        });
    }
};
