<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use App\Models\DocumentType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentRequestAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.document-requests.index', [
            'requests' => DocumentRequest::latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.document-requests.form', [
            'documentRequest' => new DocumentRequest(),
            'documentTypes' => DocumentType::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only(['document_type_id', 'applicant_name', 'applicant_nik', 'applicant_phone', 'purpose', 'tracking_code', 'status']);
        $data['admin_id'] = auth()->id();
        
        if (!$request->filled('request_number')) {
            $data['request_number'] = 'REQ-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(5));
        } else {
            $data['request_number'] = $request->input('request_number');
        }

        if (!$request->filled('tracking_code')) {
            $data['tracking_code'] = strtoupper(\Illuminate\Support\Str::random(10));
        }

        DocumentRequest::create($data);

        return redirect()->route('admin.document-requests.index');
    }

    public function edit(DocumentRequest $documentRequest): View
    {
        return view('admin.document-requests.form', [
            'documentRequest' => $documentRequest,
            'documentTypes' => DocumentType::all(),
        ]);
    }

    public function update(Request $request, DocumentRequest $documentRequest): RedirectResponse
    {
        $data = $request->only(['document_type_id', 'applicant_name', 'applicant_nik', 'applicant_phone', 'purpose', 'tracking_code', 'status']);
        
        if ($request->input('mark_completed') == '1' && !$documentRequest->completed_at) {
            $data['completed_at'] = now();
            $data['status'] = \App\Enums\DocumentRequestStatus::COMPLETED->value;
        }

        $documentRequest->update($data);

        return redirect()->route('admin.document-requests.index');
    }

    public function destroy(DocumentRequest $documentRequest): RedirectResponse
    {
        $documentRequest->delete();

        return redirect()->route('admin.document-requests.index');
    }
}
