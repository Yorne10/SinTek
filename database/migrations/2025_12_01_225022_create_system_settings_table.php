<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed initial data
        DB::table('system_settings')->insert([
            ['key' => 'institution_name', 'value' => config('app.institution_name', 'CETAM'), 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'system_name', 'value' => 'SinTek', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'contact_email', 'value' => 'contacto@cetam.gob.mx', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'contact_phone', 'value' => config('app.contact_phone', '(999) 999-9999'), 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'session_timeout', 'value' => config('session.lifetime', 120), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
