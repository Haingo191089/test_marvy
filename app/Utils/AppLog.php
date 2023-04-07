<?php
namespace App\Utils;

use Illuminate\Support\Facades\Log;

class AppLog 
{
    private static function isWriteLog () {
        return config("app.is_write_log");
    }

    private static function arrayWrapper ($data) {
        if (gettype($data) != 'array') {
            $data = [$data];
        }
        return $data;
    }

    public static function logInfo ($message, $data = []) {
        if (!self::isWriteLog()) {
            return;
        }

        Log::info($message, self::arrayWrapper($data));
    }

    public static function logError ($message, $data = []) {
        if (!self::isWriteLog()) {
            return;
        }

        Log::error($message, self::arrayWrapper($data));
    }
}