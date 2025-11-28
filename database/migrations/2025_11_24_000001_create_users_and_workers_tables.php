<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_11_24_000001_create_users_and_workers_tables.php
 * Created on: 24/11/2025
 * Created by: Codex - Consolidation
 * Approved by: Alfonso Angel García Hernández
 *
 * Description: Creates users and workers tables with all required fields
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Users table
        Schema::create('users', function (Blueprint $table) {
            $table->id('users_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'secretary', 'worker'])->default('worker');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        // Password resets table
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Workers table (profile information for workers)
        Schema::create('workers', function (Blueprint $table) {
            $table->id('workers_id');
            $table->foreignId('user_id')->nullable()->constrained('users', 'users_id')->onDelete('cascade');
            $table->string('curp', 20)->nullable()->unique();
            $table->string('rfc', 20)->nullable()->unique();
            $table->string('sex', 10)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('adress', 255)->nullable();
            $table->timestamps();
        });

        // Positions table
        Schema::create('positions', function (Blueprint $table) {
            $table->id('positions_id');
            $table->string('budget_key', 100)->nullable();
            $table->string('position_name', 150);
            $table->timestamps();
        });

        // Positions-Workers pivot table (many-to-many)
        Schema::create('positions_workers', function (Blueprint $table) {
            $table->foreignId('positions_id')->constrained('positions', 'positions_id')->onDelete('cascade');
            $table->foreignId('worker_id')->constrained('workers', 'workers_id')->onDelete('cascade');
            $table->primary(['positions_id', 'worker_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('positions_workers');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('workers');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('users');
    }
};
