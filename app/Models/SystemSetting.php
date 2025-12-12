<?php
/**
 * Empresa: CETAM
 * Proyecto: ST
 * Archivo: SystemSetting.php
 * Fecha de creación: 02/11/25
 * Realizado por: Alfonso Angel García Hernández
 * Validado por: Alfonso Angel García Hernández
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    protected $primaryKey = 'system_setting_id';

    protected $fillable = ['key', 'value', 'category', 'status'];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getValue($key, $default = null)
    {
        // Cache settings for 60 minutes to reduce DB queries
        return Cache::remember("system_setting_{$key}", 60, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value by key.
     *
     * @param string $key
     * @param mixed $value
     * @param string $category
     * @return void
     */
    public static function setValue($key, $value, $category = 'general')
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'category' => $category, 'status' => true]
        );

        // Clear cache for this key
        Cache::forget("system_setting_{$key}");
    }
}
