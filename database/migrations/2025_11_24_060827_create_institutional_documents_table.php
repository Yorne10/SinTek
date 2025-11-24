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
        Schema::create('institutional_documents', function (Blueprint $table) {
            $table->id('institutional_document_id');
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->string('category', 50); // 'reglamento', 'manual', 'lineamiento', 'codigo', 'otro'
            $table->binary('file_content'); // Archivo en BLOB
            $table->string('file_name', 255); // Nombre original del archivo
            $table->string('mime_type', 100)->default('application/pdf');
            $table->unsignedBigInteger('file_size')->nullable(); // Tamaño en bytes
            $table->string('version', 20)->default('1.0');
            $table->enum('status', ['vigente', 'archivado', 'borrador'])->default('vigente');
            $table->date('effective_date')->nullable(); // Fecha de vigencia
            $table->unsignedBigInteger('uploaded_by')->nullable(); // Usuario que subió
            $table->timestamps();
            $table->softDeletes(); // Para borrado suave

            // Índices
            $table->index('category');
            $table->index('status');
            $table->index('effective_date');

            // Relación con usuarios
            $table->foreign('uploaded_by')->references('users_id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutional_documents');
    }
};
