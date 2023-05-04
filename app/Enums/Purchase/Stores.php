<?php

namespace App\Enums\Purchase;

use App\Traits\EnumRondom;

enum Stores: string
{
    use EnumRondom;
    case Apple = 'apple';
    case Google = 'google';
    case Windows = 'windows';


}
