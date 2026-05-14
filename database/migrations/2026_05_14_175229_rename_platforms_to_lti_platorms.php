<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('platforms', 'lti_platforms');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::rename('lti_platforms', 'platforms');
    }
};
