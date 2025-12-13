<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_11_24_000004_create_positions_workers_table.php
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
        Schema::create('positions_workers', function (Blueprint $table) {
            $table->foreignId('positions_id')->constrained('positions', 'positions_id')->onDelete('cascade');
            $table->foreignId('workers_id')->constrained('workers', 'workers_id')->onDelete('cascade');
            $table->timestamp('assigned_at')->nullable();

            $table->primary(['positions_id', 'workers_id']);
            $table->index('positions_id');
            $table->index('workers_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions_workers');
    }
};
