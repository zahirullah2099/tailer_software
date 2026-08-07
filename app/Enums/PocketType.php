<?php

namespace App\Enums;

enum PocketType: string
{
    case NONE = 'none';
    case SIDE = 'side';
    case FRONT = 'front';
    case BOTH = 'both';
}
