<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_12_14_000001_create_step_provided_documents_table.php
 * Created on: 14/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('step_provided_documents', function (Blueprint $table) {
            $table->id('document_id');
            $table->unsignedBigInteger('step_id');
            $table->string('name', 255);
            $table->binary('file_content')->nullable();
            $table->string('mime_type', 255);
            $table->timestamps();

            $table->foreign('step_id')
                ->references('step_id')
                ->on('steps')
                ->onDelete('cascade');

            $table->index('step_id');
        });

        // Modify to LONGBLOB for larger files (up to 4GB)
        \DB::statement('ALTER TABLE step_provided_documents MODIFY file_content LONGBLOB NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('step_provided_documents');
    }
};
