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
        Schema::create('institucional_documents', function (Blueprint $table) {
            $table->id('institucional_document_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category');
            $table->string('file_name');
            $table->string('mime_type');
            $table->date('effective_date')->nullable();
            $table->timestamps();
        });

        // Agregar columna LONGBLOB después de crear la tabla
        DB::statement('ALTER TABLE institucional_documents ADD file_content LONGBLOB AFTER category');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institucional_documents');
    }
};
