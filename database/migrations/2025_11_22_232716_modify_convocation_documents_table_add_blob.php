<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('convocation_documents', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });

        // Usar una consulta SQL directa para agregar LONGBLOB
        DB::statement('ALTER TABLE convocation_documents ADD file_content LONGBLOB AFTER title');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('convocation_documents', function (Blueprint $table) {
            $table->dropColumn('file_content');
            $table->string('file_path', 255)->after('title');
        });
    }
};
