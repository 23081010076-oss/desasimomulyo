<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentTypeAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.document-types.index', [
            'documentTypes' => DocumentType::latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.document-types.form', ['documentType' => new DocumentType()]);
    }

    public function store(Request $request): RedirectResponse
    {
        DocumentType::create($request->only(['name', 'code', 'description']));

        return redirect()->route('admin.document-types.index');
    }

    public function edit(DocumentType $documentType): View
    {
        return view('admin.document-types.form', compact('documentType'));
    }

    public function update(Request $request, DocumentType $documentType): RedirectResponse
    {
        $documentType->update($request->only(['name', 'code', 'description']));

        return redirect()->route('admin.document-types.index');
    }

    public function destroy(DocumentType $documentType): RedirectResponse
    {
        $documentType->delete();

        return redirect()->route('admin.document-types.index');
    }
}
