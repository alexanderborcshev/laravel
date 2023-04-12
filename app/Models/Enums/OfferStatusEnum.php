<?php

namespace App\Models\Enums;

enum OfferStatusEnum
{
    use EnumToArray;
    case new;
    case wait_public;
    case public;
    case paused;
}
