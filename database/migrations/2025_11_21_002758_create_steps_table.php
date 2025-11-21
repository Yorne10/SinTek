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
        Schema::create('steps', function (Blueprint $table) {
            $table->id('step_id');
            $table->foreignId('process_id')->constrained('processes', 'process_id');
            $table->integer('order');
            $table->string('tittle', 200)->nullable();
            $table->text('description')->nullable();
            $table->string('condition_type', 50)->nullable();
            $table->foreignId('next_yes')->nullable()->constrained('steps', 'step_id');
            $table->foreignId('next_no')->nullable()->constrained('steps', 'step_id');
            $table->timestamps();
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
