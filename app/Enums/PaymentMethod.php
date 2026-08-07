<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case BANK = 'bank';
    case EASYPAISA = 'easypaisa';
    case JAZZCASH = 'jazzcash';
}
