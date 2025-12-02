<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // Add mime_type column
            if (!Schema::hasColumn('documents', 'mime_type')) {
                $table->string('mime_type', 100)->nullable()->after('name');
            }
        });

        // Add file_content column as LONGBLOB
        // Using raw SQL for LONGBLOB to ensure compatibility across DB drivers that support it
        DB::statement("ALTER TABLE documents ADD COLUMN file_content LONGBLOB NULL AFTER mime_type");
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasColumn('documents', 'mime_type')) {
                $table->dropColumn('mime_type');
            }
            if (Schema::hasColumn('documents', 'file_content')) {
                $table->dropColumn('file_content');
            }
        });
    }
};
