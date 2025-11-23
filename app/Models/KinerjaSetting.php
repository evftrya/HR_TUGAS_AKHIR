<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KinerjaSetting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'description'];

    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        if (!$setting) {
            return $default;
        }
        return self::castValue($setting->value, $setting->type);
    }

    public static function set($key, $value, $type = 'string', $description = null)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'description' => $description]
        );
    }

    private static function castValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'number':
                return is_numeric($value) ? (float)$value : 0;
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }
}
