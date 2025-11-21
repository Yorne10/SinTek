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
        Schema::create('request_steps', function (Blueprint $table) {
            $table->id('request_step_id');
            $table->foreignId('request_id')->constrained('requests', 'request_id');
            $table->foreignId('step_id')->constrained('steps', 'step_id');
            $table->foreignId('user_id')->nullable()->constrained('users', 'users_id');
            $table->string('request_step_status', 50)->nullable();
            $table->dateTime('step_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_steps');
    }
};
