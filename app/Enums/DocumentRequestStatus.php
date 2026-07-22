<?php

namespace App\Enums;

enum DocumentRequestStatus: string
{
    case DRAFT = 'DRAFT';
    case VERIFYING = 'VERIFYING';
    case SIGNED = 'SIGNED';
    case COMPLETED = 'COMPLETED';
}
