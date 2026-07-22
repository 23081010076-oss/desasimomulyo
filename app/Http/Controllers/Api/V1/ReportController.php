<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\TriggerPanicRequest;
use App\Http\Resources\ReportResource;
use App\Services\ReportService;

class ReportController extends Controller
{
    public function __construct(protected ReportService $reportService)
    {
    }

    public function store(StoreReportRequest $request): ReportResource
    {
        $report = $this->reportService->store([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return new ReportResource($report);
    }

    public function panic(TriggerPanicRequest $request): ReportResource
    {
        $report = $this->reportService->triggerPanicButton([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return new ReportResource($report);
    }
}
