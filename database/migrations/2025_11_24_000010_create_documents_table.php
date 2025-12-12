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
        Schema::create('documents', function (Blueprint $table) {
            $table->id('document_id');
            $table->foreignId('request_id')->constrained('requests', 'request_id')->onDelete('cascade');
            $table->foreignId('step_id')->constrained('steps', 'step_id')->onDelete('cascade');
            $table->string('name');
            $table->string('mime_type');
            $table->timestamps();

            $table->index('request_id');
            $table->index('step_id');
        });

        // Agregar columna LONGBLOB después de crear la tabla
        DB::statement('ALTER TABLE documents ADD file_content LONGBLOB AFTER step_id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
