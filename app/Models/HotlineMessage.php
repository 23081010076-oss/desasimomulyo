<?php

namespace App\Models;

use App\Enums\HotlineMessageStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotlineMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'is_urgent',
        'status',
    ];

    protected $casts = [
        'is_urgent' => 'boolean',
        'status' => HotlineMessageStatus::class,
    ];
}
