<?php

namespace App\Models\Enums;

enum OrderEventEnum: string
{
    use EnumToArray;
    use EnumByString;
    case new = 'заказ оформлен';
    case in_progress = 'взять в работу';
    case postpone = 'отложить';
    case canceled = 'отменить';
    case finished = 'погасить';
    case verified = 'проверен';
    case note = 'заметка';
}
