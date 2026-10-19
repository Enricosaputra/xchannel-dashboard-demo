<?php

namespace App\Support;

use InvalidArgumentException;

// Schedule times are stored as minutes since midnight. These turn them into "HH:MM" and back.
final class Clock
{
    public static function toMinutes(string $time): int
    {
        if (! preg_match('/^([01]\d|2[0-4]):([0-5]\d)$/D', $time, $m) || ($m[1] === '24' && $m[2] !== '00')) {
            throw new InvalidArgumentException("Not a time: {$time}");
        }

        return (int) $m[1] * 60 + (int) $m[2];
    }

    public static function format(int $minutes): string
    {
        return sprintf('%02d:%02d', intdiv($minutes, 60), $minutes % 60);
    }

    public static function hours(int $minutes): string
    {
        return rtrim(rtrim(number_format($minutes / 60, 1, ',', '.'), '0'), ',');
    }
}
