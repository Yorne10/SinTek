<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_11_24_000008_create_requests_table.php
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
        Schema::create('requests', function (Blueprint $table) {
            $table->id('request_id');
            $table->foreignId('worker_id')->constrained('workers', 'workers_id')->onDelete('cascade');
            $table->foreignId('process_id')->constrained('processes', 'process_id')->onDelete('cascade');
            $table->string('status');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();

            $table->index('worker_id');
            $table->index('process_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
