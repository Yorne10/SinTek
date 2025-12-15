<?php
/**
 * Company: CETAM
 * Project: ST
 * File: SystemSettingSeeder.php
 * Created on: 15/12/2025
 * Created by: ChatGPT (assisted)
 * Approved by: -
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemSetting;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'institution_name',
                'value' => config('app.institution_name', env('APP_INSTITUTION_NAME', 'CETAM')),
                'category' => 'general',
            ],
            [
                'key' => 'system_name',
                'value' => config('app.name', env('APP_NAME', 'SinTek')),
                'category' => 'general',
            ],
            [
                'key' => 'contact_email',
                'value' => config('app.contact_email', config('mail.from.address', env('APP_CONTACT_EMAIL', 'contacto@cetam.gob.mx'))),
                'category' => 'contact',
            ],
            [
                'key' => 'contact_phone',
                'value' => config('app.contact_phone', env('APP_CONTACT_PHONE', '(999) 999-9999')),
                'category' => 'contact',
            ],
            [
                'key' => 'session_timeout',
                'value' => (string) config('session.lifetime', env('SESSION_LIFETIME', 120)),
                'category' => 'security',
            ],
        ];

        foreach ($settings as $setting) {
            SystemSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'category' => $setting['category'],
                    'status' => true,
                ]
            );
        }

        $this->command->info('ƒo. System settings iniciales creados/actualizados: ' . count($settings));
    }
}
