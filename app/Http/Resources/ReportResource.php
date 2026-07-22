<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'report_category_id' => $this->report_category_id,
            'title' => $this->title,
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'image_path' => $this->image_path,
            'status' => $this->status,
            'is_emergency' => $this->is_emergency,
            'created_at' => $this->created_at,
        ];
    }
}
