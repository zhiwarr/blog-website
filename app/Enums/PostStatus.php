<?php

namespace App\Enums;

enum PostStatus: string
{
    case PUBLISHED = 'published';
    case UNPUBLISHED = 'unpublished';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): void
    {
        match ($this) {
            self::PUBLISHED => __('published'),
            self::UNPUBLISHED => __('unpublished'),
        };
    }
}
