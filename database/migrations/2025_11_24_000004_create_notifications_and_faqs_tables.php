<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_11_24_000004_create_notifications_and_faqs_tables.php
 * Created on: 24/11/2025
 * Created by: Codex - Consolidation
 * Approved by: Alfonso Angel García Hernández
 *
 * Description: Creates notifications and FAQs tables with categories
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Notifications table
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notification_id');
            $table->foreignId('request_id')->nullable()->constrained('requests', 'request_id')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users', 'users_id')->onDelete('cascade');
            $table->foreignId('steps_id')->nullable()->constrained('steps', 'step_id')->onDelete('set null');
            $table->foreignId('convocations_id')->nullable()->constrained('convocations', 'convocation_id')->onDelete('set null');
            $table->string('tittle', 200)->nullable();
            $table->text('message')->nullable();
            $table->dateTime('read_at')->nullable();
            $table->string('type', 50)->nullable();
            $table->timestamps();
        });

        // FAQ Categories table
        Schema::create('faq_categories', function (Blueprint $table) {
            $table->id('faq_category_id');
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // FAQs table
        Schema::create('faqs', function (Blueprint $table) {
            $table->id('faq_id');
            $table->foreignId('faq_category_id')->nullable()->constrained('faq_categories', 'faq_category_id')->onDelete('set null');
            $table->string('question', 255);
            $table->text('answer');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('faq_categories');
        Schema::dropIfExists('notifications');
    }
};
