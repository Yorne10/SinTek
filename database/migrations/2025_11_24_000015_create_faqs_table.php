<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_11_24_000015_create_faqs_table.php
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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id('faq_id');
            $table->foreignId('faq_category_id')->constrained('faqs_categories', 'faq_category_id')->onDelete('cascade');
            $table->text('question');
            $table->text('answer');
            $table->integer('order');
            $table->timestamps();

            $table->index('faq_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
