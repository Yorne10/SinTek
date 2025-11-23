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
        Schema::create('convocation_documents', function (Blueprint $table) {
            $table->id('convocation_document_id');
            $table->unsignedBigInteger('convocation_id');
            $table->string('title', 150);
            $table->string('file_path', 255);
            $table->timestamps();

            $table->foreign('convocation_id')->references('convocation_id')->on('convocations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convocation_documents');
    }
};
