<?php

namespace App\Enums;

use App\Traits\EnumRondom;

enum StoreEnum: string
{
    use EnumRondom;

    case Apple = 'apple';
    case Google = 'google';
    case Windows = 'windows';


}
