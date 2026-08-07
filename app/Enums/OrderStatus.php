<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case CUTTING = 'cutting';
    case STITCHING = 'stitching';
    case IRONING = 'ironing';
    case READY = 'ready';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
}
