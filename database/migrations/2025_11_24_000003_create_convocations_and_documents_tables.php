<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_11_24_000003_create_convocations_and_documents_tables.php
 * Created on: 24/11/2025
 * Created by: Codex - Consolidation
 * Approved by: Alfonso Angel García Hernández
 *
 * Description: Creates convocations, institutional documents, and related tables
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Convocations table
        Schema::create('convocations', function (Blueprint $table) {
            $table->id('convocation_id');
            $table->string('title', 150)->nullable();
            $table->text('description')->nullable();
            $table->string('file_path', 255)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Convocation documents table (PDF files stored as BLOB)
        Schema::create('convocation_documents', function (Blueprint $table) {
            $table->id('convocation_document_id');
            $table->foreignId('convocation_id')->constrained('convocations', 'convocation_id')->onDelete('cascade');
            $table->string('title', 255);
            $table->binary('file_content');
            $table->timestamps();
            $table->softDeletes();
        });

        // Institutional documents table (reglamentos, manuales, etc. - stored as BLOB)
        Schema::create('institutional_documents', function (Blueprint $table) {
            $table->id('institutional_document_id');
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->enum('category', ['reglamento', 'manual', 'formato', 'lineamiento', 'otro'])->default('otro');
            $table->binary('file_content');
            $table->string('file_name', 255);
            $table->string('mime_type', 100)->default('application/pdf');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('version', 20)->default('1.0');
            $table->enum('status', ['vigente', 'archivado', 'borrador'])->default('vigente');
            $table->date('effective_date')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users', 'users_id')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institutional_documents');
        Schema::dropIfExists('convocation_documents');
        Schema::dropIfExists('convocations');
    }
};
