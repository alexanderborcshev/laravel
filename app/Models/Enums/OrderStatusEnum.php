<?php

namespace App\Models\Enums;

enum OrderStatusEnum
{
    use EnumToArray;
    case new;
    case in_progress;
    case postpone;
    case canceled;
    case finished;
}
