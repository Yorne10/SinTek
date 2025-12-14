<?php
/**
 * Company: CETAM
 * Project: ST
 * File: 2025_12_14_143404_change_requests_date_columns_to_datetime.php
 * Created on: 14/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: 001 | Modified on: 14/12/2025 |
 * Modified by: Alfonso Angel Garcia Hernandez |
 * Description: Change date columns to datetime to store time information |
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
        Schema::table('requests', function (Blueprint $table) {
            $table->dateTime('start_date')->change();
            $table->dateTime('end_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->date('start_date')->change();
            $table->date('end_date')->nullable()->change();
        });
    }
};
