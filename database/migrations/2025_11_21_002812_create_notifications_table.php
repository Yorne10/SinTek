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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notification_id');
            $table->foreignId('request_id')->nullable()->constrained('requests', 'request_id');
            $table->foreignId('user_id')->nullable()->constrained('users', 'users_id');
            $table->foreignId('steps_id')->nullable()->constrained('steps', 'step_id');
            $table->foreignId('convocations_id')->nullable()->constrained('convocations', 'convocation_id');
            $table->string('tittle', 200)->nullable();
            $table->text('message')->nullable();
            $table->dateTime('read_at')->nullable();
            $table->string('type', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
