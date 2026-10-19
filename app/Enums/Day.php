<?php

namespace App\Enums;

// ISO-8601 day numbers, the same as Carbon's dayOfWeekIso.
enum Day: int
{
    case Monday = 1;
    case Tuesday = 2;
    case Wednesday = 3;
    case Thursday = 4;
    case Friday = 5;
    case Saturday = 6;
    case Sunday = 7;

    public function label(): string
    {
        return __($this->name);
    }

    public function short(): string
    {
        return mb_substr($this->label(), 0, 3);
    }

    public function next(): self
    {
        return self::from($this->value % 7 + 1);
    }
}
