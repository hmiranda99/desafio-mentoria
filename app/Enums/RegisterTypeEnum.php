<?php

namespace App\Enums;

enum RegisterTypeEnum: string
{
    case CANCEL = 'cancel';
    case AUTHORIZE = 'authorize';
}
