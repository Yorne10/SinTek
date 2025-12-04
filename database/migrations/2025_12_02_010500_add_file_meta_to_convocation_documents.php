<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('convocation_documents', function (Blueprint $table) {
            $table->string('file_name', 255)->nullable()->after('title');
            $table->string('mime_type', 100)->nullable()->after('file_name');
            $table->integer('file_size')->nullable()->after('mime_type');
        });
    }

    public function down(): void
    {
        Schema::table('convocation_documents', function (Blueprint $table) {
            $table->dropColumn(['file_name', 'mime_type', 'file_size']);
        });
    }
};
