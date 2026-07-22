<?php

namespace App\Services;

use App\Enums\ReportStatus;
use App\Jobs\SendEmergencyWhatsAppJob;
use App\Repositories\Contracts\ReportRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function __construct(
        protected ReportRepositoryInterface $reportRepository,
    ) {
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            $data['status'] = ReportStatus::PENDING->value;
            $data['is_emergency'] = false;

            return $this->reportRepository->create($data);
        });
    }

    public function triggerPanicButton(array $data)
    {
        return DB::transaction(function () use ($data) {
            $report = $this->reportRepository->create([
                'user_id' => $data['user_id'],
                'report_category_id' => $data['report_category_id'] ?? null,
                'title' => 'PANIC BUTTON',
                'description' => $data['description'] ?? 'Panic button activated from citizen app.',
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'image_path' => $data['image_path'] ?? 'emergency/no-image.jpg',
                'status' => ReportStatus::EMERGENCY->value,
                'is_emergency' => true,
                'metadata' => [
                    'source' => 'panic_button',
                    'triggered_at' => now()->toIso8601String(),
                ],
            ]);

            SendEmergencyWhatsAppJob::dispatch($report)->afterCommit();

            return $report;
        });
    }
}
