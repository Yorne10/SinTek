<?php
/**
 * Empresa: CETAM
 * Proyecto: ST
 * Archivo: 2025_11_02_000200_create_workers_table.php
 * Fecha de creación: 02/11/25
 * Realizado por: Alfonso Angel García Hernández
 * Validado por: Alfonso Angel García Hernández
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('workers')) {
            Schema::create('workers', function (Blueprint $table) {
                $table->id('workers_id');
                $table->foreignId('user_id')->nullable()->constrained('users', 'users_id');
                $table->string('curp', 20)->nullable();
                $table->string('sex', 10)->nullable();
                $table->string('phone', 20)->nullable();
                $table->string('adress', 255)->nullable();
                $table->string('rfc', 20)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
