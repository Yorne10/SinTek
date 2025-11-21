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
        Schema::create('positions_workers', function (Blueprint $table) {
            $table->foreignId('positions_id')->constrained('positions', 'positions_id');
            $table->foreignId('worker_id')->constrained('workers', 'workers_id');
            $table->primary(['positions_id', 'worker_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions_workers');
    }
};
