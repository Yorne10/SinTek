<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_11_24_000006_create_steps_table.php
 * Created on: 12/12/2025
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
        Schema::create('steps', function (Blueprint $table) {
            $table->id('step_id');
            $table->foreignId('process_id')->constrained('processes', 'process_id')->onDelete('cascade');
            $table->string('title');
            $table->text('instruction');
            $table->unsignedInteger('order')->nullable();
            $table->enum('step_type', ['initial', 'conditional', 'final', 'normal'])->default('initial');
            $table->text('condition_question')->nullable();
            $table->boolean('requires_documents')->default(false);
            $table->foreignId('next_step_id')->nullable()->constrained('steps', 'step_id')->onDelete('set null');
            $table->foreignId('next_yes')->nullable()->constrained('steps', 'step_id')->onDelete('set null');
            $table->foreignId('next_no')->nullable()->constrained('steps', 'step_id')->onDelete('set null');
            $table->text('finalization_message')->nullable();
            $table->boolean('is_initial_step')->default(false);
            $table->boolean('is_linked')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->index('process_id');
            $table->index('next_step_id');
            $table->index('next_yes');
            $table->index('next_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steps');
    }
};
