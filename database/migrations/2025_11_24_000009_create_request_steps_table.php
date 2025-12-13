<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_11_24_000009_create_request_steps_table.php
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
        Schema::create('request_steps', function (Blueprint $table) {
            $table->id('request_step_id');
            $table->foreignId('request_id')->constrained('requests', 'request_id')->onDelete('cascade');
            $table->foreignId('step_id')->constrained('steps', 'step_id')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users', 'users_id')->onDelete('set null');
            $table->string('request_step_status');
            $table->timestamp('step_date')->nullable();
            $table->boolean('conditional_answer')->nullable();
            $table->timestamps();

            $table->index('request_id');
            $table->index('step_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_steps');
    }
};
