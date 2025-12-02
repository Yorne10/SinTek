<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('convocation_documents', function (Blueprint $table) {
            DB::statement("ALTER TABLE convocation_documents MODIFY file_content LONGBLOB");
        });

        Schema::table('institutional_documents', function (Blueprint $table) {
            DB::statement("ALTER TABLE institutional_documents MODIFY file_content LONGBLOB");
        });
    }

    public function down(): void
    {
        Schema::table('convocation_documents', function (Blueprint $table) {
            DB::statement("ALTER TABLE convocation_documents MODIFY file_content BLOB");
        });

        Schema::table('institutional_documents', function (Blueprint $table) {
            DB::statement("ALTER TABLE institutional_documents MODIFY file_content BLOB");
        });
    }
};
