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
        Schema::create('workers', function (Blueprint $table) {
            $table->id('workers_id');
            $table->foreignId('user_id')->constrained('users', 'users_id')->onDelete('cascade');
            $table->string('curp')->unique();
            $table->string('sex');
            $table->string('phone');
            $table->string('address');
            $table->string('rfc');
            $table->timestamps();

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
