<?php

namespace App\Enums;

enum ReportStatus: string
{
    case PENDING = 'PENDING';
    case PROCESSED = 'PROCESSED';
    case RESOLVED = 'RESOLVED';
    case REJECTED = 'REJECTED';
    case EMERGENCY = 'EMERGENCY';
}
