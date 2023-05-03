<?php

namespace App\Enums\Purchase;

use App\Traits\EnumRondom;
use App\Traits\EnumToArray;

enum PurchaseStatus: string
{
    use EnumRondom;
    use EnumToArray;


    case Started = 'started';
    case Renewed = 'renewed';
    case Canceled = 'canceled';

}
