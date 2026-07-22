<?php

namespace App\Http\Controllers;

use App\Enums\HotlineMessageStatus;
use App\Http\Requests\StoreHotlineMessageRequest;
use App\Models\HotlineMessage;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HotlineController extends Controller
{
    public function index(): View
    {
        $village = array_merge(config('village'), Setting::pluck('value', 'key')->toArray());
        return view('site.hotline', compact('village'));
    }

    public function store(StoreHotlineMessageRequest $request): RedirectResponse
    {
        HotlineMessage::create([
            ...$request->validated(),
            'is_urgent' => $request->boolean('is_urgent'),
            'status' => HotlineMessageStatus::PENDING->value,
        ]);

        return redirect()->route('hotline')->with('success', 'Pesan hotline berhasil dikirim.');
    }
}
