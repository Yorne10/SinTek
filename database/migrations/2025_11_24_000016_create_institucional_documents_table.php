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
        Schema::create('institucional_documents', function (Blueprint $table) {
            $table->id('institucional_document_id');
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->longText('file_content');
            $table->string('file_name');
            $table->string('mime_type');
            $table->date('effective_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institucional_documents');
    }
};
