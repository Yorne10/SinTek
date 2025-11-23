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
        Schema::table('processes', function (Blueprint $table) {
            $table->string('process_code', 50)->nullable()->after('name');
            $table->string('category', 100)->nullable()->after('description');
            $table->string('priority', 20)->nullable()->after('category');
            $table->integer('deadline_days')->nullable()->after('priority');
            $table->string('department', 100)->nullable()->after('deadline_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('processes', function (Blueprint $table) {
            $table->dropColumn(['process_code', 'category', 'priority', 'deadline_days', 'department']);
        });
    }
};
