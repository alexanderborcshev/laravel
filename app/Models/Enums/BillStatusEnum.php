<?php

namespace App\Models\Enums;

enum BillStatusEnum
{
    use EnumToArray;
    case new;
    case payed;
}
