<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_11_24_000005_create_processes_table.php
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
        Schema::create('processes', function (Blueprint $table) {
            $table->id('process_id');
            $table->string('process_code')->unique();
            $table->string('name');
            $table->text('description');
            $table->string('category');
            $table->boolean('active')->default(true);
            $table->string('department');
            $table->foreignId('created_by')->constrained('users', 'users_id')->onDelete('cascade');
            $table->timestamps();

            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processes');
    }
};
