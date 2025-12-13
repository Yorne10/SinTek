<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_11_24_000012_create_convocation_docs_table.php
 * Created on: 12/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

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
        Schema::create('convocation_docs', function (Blueprint $table) {
            $table->id('convocation_doc_id');
            $table->foreignId('convocation_id')->constrained('convocations', 'convocation_id')->onDelete('cascade');
            $table->string('file_name');
            $table->string('mime_type');
            $table->timestamp('created_at')->useCurrent();

            $table->index('convocation_id');
        });

        // Agregar columna LONGBLOB después de crear la tabla
        DB::statement('ALTER TABLE convocation_docs ADD file_content LONGBLOB AFTER mime_type');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convocation_docs');
    }
};
