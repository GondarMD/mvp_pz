<?php

namespace App\Enums;


enum OptionAttributes: string
{

    case COLOR = 'color';
    case SIZE = 'size';
    case MATERIAL = 'material';
    case STYLE = 'style';
    case BRAND = 'brand';

    public  static function labels(): array {
        return [
            self::COLOR->value => 'Color',
            self::SIZE->value => 'Size',
            self::MATERIAL->value => 'Material',
            self::STYLE->value => 'Style',
            self::BRAND->value => 'Brand',
        ];
    }

    public static function options(): array
    {
        return array_map(
            fn($case) => ['value' => $case->value, 'label' => self::labels()[$case->value]],
            self::cases()
        );
    }
}
