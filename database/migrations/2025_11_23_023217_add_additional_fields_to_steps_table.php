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
        Schema::table('steps', function (Blueprint $table) {
            $table->text('instructions')->nullable()->after('description');
            $table->string('responsible', 100)->nullable()->after('condition_type');
            $table->integer('deadline_days')->nullable()->after('responsible');
            $table->string('priority', 50)->default('media')->after('deadline_days');
            $table->boolean('send_notification')->default(false)->after('priority');
            $table->boolean('requires_documents')->default(false)->after('send_notification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('steps', function (Blueprint $table) {
            $table->dropColumn([
                'instructions',
                'responsible',
                'deadline_days',
                'priority',
                'send_notification',
                'requires_documents'
            ]);
        });
    }
};
