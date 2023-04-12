<?php

namespace App\Models\Enums;

trait EnumByString
{
    public static function valueByStringName(string $string): string
    {
        $value = '';
        foreach (self::cases() as $case) {
            if ($case->name === $string) {
                $value = $case->value;
            }
        }
        return $value;
    }
}
