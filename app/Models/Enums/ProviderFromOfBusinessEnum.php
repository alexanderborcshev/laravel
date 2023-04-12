<?php

namespace App\Models\Enums;

enum ProviderFromOfBusinessEnum: string
{
    use EnumToArray;
    case ip = 'ИП';
    case ooo = 'ООО';
    case ao = 'АО';
}
