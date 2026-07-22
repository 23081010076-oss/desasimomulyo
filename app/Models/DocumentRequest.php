<?php

namespace App\Models;

use App\Enums\DocumentRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'applicant_name',
        'applicant_nik',
        'applicant_phone',
        'purpose',
        'tracking_code',
        'document_type_id',
        'admin_id',
        'request_number',
        'payload',
        'status',
        'signed_at',
        'completed_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'signed_at' => 'datetime',
        'completed_at' => 'datetime',
        'status' => DocumentRequestStatus::class,
    ];

    public function citizen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }
}
