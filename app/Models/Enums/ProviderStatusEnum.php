<?php

namespace App\Models\Enums;

enum ProviderStatusEnum
{
    use EnumToArray;
    case blocked;
    case active;
}
