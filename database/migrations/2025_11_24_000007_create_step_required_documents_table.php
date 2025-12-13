<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_11_24_000007_create_step_required_documents_table.php
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

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('step_required_documents', function (Blueprint $table) {
            $table->id('step_required_documents_id');
            $table->foreignId('step_id')->constrained('steps', 'step_id')->onDelete('cascade');
            $table->string('title');
            $table->timestamps();

            $table->index('step_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('step_required_documents');
    }
};
