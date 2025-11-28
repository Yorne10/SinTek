<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_11_24_000002_create_processes_and_steps_tables.php
 * Created on: 24/11/2025
 * Created by: Codex - Consolidation
 * Approved by: Alfonso Angel García Hernández
 *
 * Description: Creates processes, steps, and related tables for workflow management
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Processes table
        Schema::create('processes', function (Blueprint $table) {
            $table->id('process_id');
            $table->string('name', 150);
            $table->string('process_code', 50)->nullable();
            $table->text('description')->nullable();
            $table->string('category', 100)->nullable();
            $table->string('priority', 20)->nullable();
            $table->integer('deadline_days')->nullable();
            $table->string('department', 100)->nullable();
            $table->boolean('active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users', 'users_id')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });

        // Steps table
        Schema::create('steps', function (Blueprint $table) {
            $table->id('step_id');
            $table->foreignId('process_id')->constrained('processes', 'process_id')->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->string('tittle', 200);
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();
            $table->string('condition_type', 50)->nullable();
            $table->string('responsible', 100)->nullable();
            $table->integer('deadline_days')->nullable();
            $table->string('priority', 50)->default('media');
            $table->boolean('send_notification')->default(false);
            $table->boolean('requires_documents')->default(false);
            $table->foreignId('next_yes')->nullable()->constrained('steps', 'step_id')->onDelete('set null');
            $table->foreignId('next_no')->nullable()->constrained('steps', 'step_id')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });

        // Requests table (user requests/trámites)
        Schema::create('requests', function (Blueprint $table) {
            $table->id('request_id');
            $table->foreignId('worker_id')->constrained('workers', 'workers_id')->onDelete('cascade');
            $table->foreignId('process_id')->constrained('processes', 'process_id')->onDelete('cascade');
            $table->string('status', 50)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });

        // Request steps table (tracking of each step in a request)
        Schema::create('request_steps', function (Blueprint $table) {
            $table->id('request_step_id');
            $table->foreignId('request_id')->constrained('requests', 'request_id')->onDelete('cascade');
            $table->foreignId('step_id')->constrained('steps', 'step_id')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users', 'users_id')->onDelete('set null');
            $table->string('request_step_status', 50)->nullable();
            $table->dateTime('step_date')->nullable();
            $table->timestamps();
        });

        // Documents table
        Schema::create('documents', function (Blueprint $table) {
            $table->id('document_id');
            $table->foreignId('request_id')->constrained('requests', 'request_id')->onDelete('cascade');
            $table->foreignId('step_id')->constrained('steps', 'step_id')->onDelete('cascade');
            $table->string('type', 100)->nullable();
            $table->string('file_path', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
        Schema::dropIfExists('request_steps');
        Schema::dropIfExists('requests');
        Schema::dropIfExists('steps');
        Schema::dropIfExists('processes');
    }
};
