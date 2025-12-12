<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     * Update step_type ENUM to new values: form, approval, file_upload, final
     */
    public function up(): void
    {
        // Step 1: Modify ENUM to include all values (old + new)
        DB::statement("ALTER TABLE steps MODIFY COLUMN step_type ENUM('normal', 'conditional', 'finalization', 'form', 'approval', 'file_upload', 'final') DEFAULT 'form'");

        // Step 2: Update existing values to new format
        DB::table('steps')->where('step_type', 'normal')->update(['step_type' => 'form']);
        DB::table('steps')->where('step_type', 'conditional')->update(['step_type' => 'approval']);
        DB::table('steps')->where('step_type', 'finalization')->update(['step_type' => 'final']);

        // Step 3: Remove old ENUM values
        DB::statement("ALTER TABLE steps MODIFY COLUMN step_type ENUM('form', 'approval', 'file_upload', 'final') DEFAULT 'form'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Add old values back
        DB::statement("ALTER TABLE steps MODIFY COLUMN step_type ENUM('normal', 'conditional', 'finalization', 'form', 'approval', 'file_upload', 'final') DEFAULT 'normal'");

        // Step 2: Revert to old values
        DB::table('steps')->where('step_type', 'form')->update(['step_type' => 'normal']);
        DB::table('steps')->where('step_type', 'approval')->update(['step_type' => 'conditional']);
        DB::table('steps')->where('step_type', 'final')->update(['step_type' => 'finalization']);
        DB::table('steps')->where('step_type', 'file_upload')->update(['step_type' => 'normal']);

        // Step 3: Remove new ENUM values
        DB::statement("ALTER TABLE steps MODIFY COLUMN step_type ENUM('normal', 'conditional', 'finalization') DEFAULT 'normal'");
    }
};
