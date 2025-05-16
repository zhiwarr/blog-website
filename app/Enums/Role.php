<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = "admin";
    case Author = "author";
    case USER = "user";

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => __('admin'),
            self::Author => __('author'),
            self::USER => __('user'),
        };
    }
}
