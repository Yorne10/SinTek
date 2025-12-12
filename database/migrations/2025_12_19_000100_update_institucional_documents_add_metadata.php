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
        Schema::table('institucional_documents', function (Blueprint $table) {
            $table->string('version', 20)->default('1.0')->after('category');
            $table->string('status', 20)->default('active')->after('version');
            $table->unsignedBigInteger('uploaded_by')->nullable()->after('status');
            $table->integer('file_size')->nullable()->after('file_content');

            $table->foreign('uploaded_by')
                ->references('users_id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('institucional_documents', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
            $table->dropColumn(['version', 'status', 'uploaded_by', 'file_size']);
        });
    }
};
