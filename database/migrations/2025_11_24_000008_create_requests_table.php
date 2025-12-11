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
        Schema::create('requests', function (Blueprint $table) {
            $table->id('request_id');
            $table->foreignId('worker_id')->constrained('workers', 'workers_id')->onDelete('cascade');
            $table->foreignId('process_id')->constrained('processes', 'process_id')->onDelete('cascade');
            $table->string('status');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();

            $table->index('worker_id');
            $table->index('process_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
