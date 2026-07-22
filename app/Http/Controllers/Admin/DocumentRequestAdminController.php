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
        DocumentRequest::create($request->only(['user_id', 'document_type_id', 'admin_id', 'request_number', 'payload', 'status', 'signed_at', 'completed_at']));

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
        $documentRequest->update($request->only(['document_type_id', 'admin_id', 'payload', 'status', 'signed_at', 'completed_at']));

        return redirect()->route('admin.document-requests.index');
    }

    public function destroy(DocumentRequest $documentRequest): RedirectResponse
    {
        $documentRequest->delete();

        return redirect()->route('admin.document-requests.index');
    }
}
