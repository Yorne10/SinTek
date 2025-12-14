<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_12_12_000100_update_institucional_documents_add_metadata.php
 * Created on: 11/12/2025
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

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('institucional_documents', function (Blueprint $table) {
            // Only add columns if they don't exist
            if (!Schema::hasColumn('institucional_documents', 'version')) {
                $table->string('version', 20)->default('1.0')->after('category');
            }
            if (!Schema::hasColumn('institucional_documents', 'status')) {
                $table->string('status', 20)->default('active')->after('version');
            }
            if (!Schema::hasColumn('institucional_documents', 'uploaded_by')) {
                $table->unsignedBigInteger('uploaded_by')->nullable()->after('status');
            }
            if (!Schema::hasColumn('institucional_documents', 'file_size')) {
                $table->integer('file_size')->nullable()->after('file_content');
            }

            // Foreign key already exists, skip creation
            // Uncomment only if you need to recreate the foreign key
            // if (Schema::hasColumn('institucional_documents', 'uploaded_by')) {
            //     $table->foreign('uploaded_by')
            //         ->references('users_id')
            //         ->on('users')
            //         ->nullOnDelete();
            // }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('institucional_documents', function (Blueprint $table) {
            // Only drop if exists
            if (Schema::hasColumn('institucional_documents', 'uploaded_by')) {
                $table->dropForeign(['uploaded_by']);
            }
            $table->dropColumn(['version', 'status', 'uploaded_by', 'file_size']);
        });
    }
};
