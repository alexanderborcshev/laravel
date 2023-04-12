<?php

namespace App\Models\Enums;

enum OrderPostponeEnum: string
{
    use EnumToArray;
    use EnumByString;
    case week = 'на неделю';
    case month = 'на месяц';
    case three_month = 'на 3 месяца';
    case six_month = 'на 6 месяцев';
}
