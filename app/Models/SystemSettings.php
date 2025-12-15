<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSettings extends Model
{
    protected $table = 'system_settings';
    protected $primaryKey = 'id';

    protected $fillable = [
        'setting_key',
        'setting_value',
        'setting_type',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Helper method to get setting by key
    public static function get($key, $default = null)
    {
        $setting = self::where('setting_key', $key)->first();
        return $setting ? $setting->setting_value : $default;
    }

    // Helper method to set setting
    public static function set($key, $value, $type = 'string', $description = null)
    {
        return self::updateOrCreate(
            ['setting_key' => $key],
            [
                'setting_value' => $value,
                'setting_type' => $type,
                'description' => $description
            ]
        );
    }
}
