<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.reports.index', [
            'reports' => Report::latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.reports.form', [
            'report' => new Report(),
            'statuses' => ReportStatus::cases(),
        ]);
    }

    public function store(StoreReportRequest $request): RedirectResponse
    {
        Report::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
            'status' => ReportStatus::PENDING->value,
            'is_emergency' => false,
        ]);

        return redirect()->route('admin.reports.index');
    }

    public function edit(Report $report): View
    {
        return view('admin.reports.form', [
            'report' => $report,
            'statuses' => ReportStatus::cases(),
        ]);
    }

    public function update(Request $request, Report $report): RedirectResponse
    {
        $report->update($request->only(['title', 'description', 'latitude', 'longitude', 'image_path', 'status', 'is_emergency']));

        return redirect()->route('admin.reports.index');
    }

    public function destroy(Report $report): RedirectResponse
    {
        $report->delete();

        return redirect()->route('admin.reports.index');
    }
}
