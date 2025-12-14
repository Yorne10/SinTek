<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_12_13_153049_make_workers_fields_nullable.php
 * Created on: 13/12/2025
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

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            // Make all fields nullable except foreign keys
            // Note: curp already has unique index, just making it nullable
            $table->string('curp')->nullable()->change();
            $table->string('sex')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('rfc')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            // Revert to NOT NULL (be careful, this might fail if there are null values)
            $table->string('curp')->unique()->nullable(false)->change();
            $table->string('sex')->nullable(false)->change();
            $table->string('phone')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->string('rfc')->nullable(false)->change();
        });
    }
};
