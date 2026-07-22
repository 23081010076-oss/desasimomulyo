<?php

namespace App\Enums;

enum HotlineMessageStatus: string
{
    case PENDING = 'PENDING';
    case RESPONDED = 'RESPONDED';
    case CLOSED = 'CLOSED';
}
