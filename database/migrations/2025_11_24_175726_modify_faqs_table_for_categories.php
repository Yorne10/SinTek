<?php

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
        Schema::table('faqs', function (Blueprint $table) {
            // Add new columns
            $table->unsignedBigInteger('faq_category_id')->nullable()->after('faq_id');
            $table->integer('order')->default(0)->after('answer');
            $table->boolean('is_active')->default(true)->after('order');
            $table->softDeletes();

            // Add foreign key
            $table->foreign('faq_category_id')
                  ->references('faq_category_id')
                  ->on('faq_categories')
                  ->onDelete('set null');
        });

        // Rename status to match is_active
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Drop old category column (will use relation instead)
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropForeign(['faq_category_id']);
            $table->dropColumn(['faq_category_id', 'order', 'is_active', 'deleted_at']);
            $table->string('category', 100)->nullable();
            $table->tinyInteger('status')->default(1);
        });
    }
};
