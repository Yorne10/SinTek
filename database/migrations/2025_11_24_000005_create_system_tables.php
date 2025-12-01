<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_11_24_000005_create_system_tables.php
 * Created on: 24/11/2025
 * Created by: Codex - Consolidation
 * Approved by: Alfonso Angel García Hernández
 *
 * Description: Creates system tables (logs, failed jobs, tokens)
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Failed jobs table
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // Personal access tokens table (Sanctum)
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        // Logs table (system activity logs)
        Schema::create('logs', function (Blueprint $table) {
            $table->id('logs_id');
            $table->foreignId('user_id')->nullable()->constrained('users', 'users_id')->onDelete('set null');
            $table->string('action', 255)->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('description')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->dateTime('date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs');
        Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('failed_jobs');
    }
};
