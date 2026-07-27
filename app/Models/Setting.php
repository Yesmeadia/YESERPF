<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    protected static function getStoragePath(): string
    {
        return storage_path('app/settings.json');
    }

    public static function get(string $key, $default = null)
    {
        // 1. Try JSON file storage first
        $file = static::getStoragePath();
        if (File::exists($file)) {
            $data = json_decode(File::get($file), true) ?? [];
            if (array_key_exists($key, $data)) {
                return $data[$key];
            }
        }

        // 2. Try DB table if available
        try {
            if (Schema::hasTable('settings')) {
                $record = static::where('key', $key)->first();
                if ($record) {
                    return $record->value;
                }
            }
        } catch (\Throwable $e) {}

        return $default;
    }

    public static function set(string $key, $value): void
    {
        // 1. Save to JSON file
        $file = static::getStoragePath();
        $directory = dirname($file);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $data = File::exists($file) ? (json_decode(File::get($file), true) ?? []) : [];
        $data[$key] = (string) $value;
        File::put($file, json_encode($data, JSON_PRETTY_PRINT));

        // 2. Save to DB table if available
        try {
            if (Schema::hasTable('settings')) {
                static::updateOrCreate(['key' => $key], ['value' => (string) $value]);
            }
        } catch (\Throwable $e) {}
    }
}
