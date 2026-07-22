<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileGalleryImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileGalleryImageAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.profile-gallery-images.index', [
            'images' => ProfileGalleryImage::orderBy('sort_order')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.profile-gallery-images.form', [
            'image' => new ProfileGalleryImage(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'caption' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['required', 'image', 'max:4096'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['image_path'] = $this->storeImage($request->file('image'));

        ProfileGalleryImage::create($validated);

        return redirect()->route('admin.profile-gallery-images.index');
    }

    public function edit(ProfileGalleryImage $profileGalleryImage): View
    {
        return view('admin.profile-gallery-images.form', [
            'image' => $profileGalleryImage,
        ]);
    }

    public function update(Request $request, ProfileGalleryImage $profileGalleryImage): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'caption' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $this->deleteImage($profileGalleryImage->image_path);
            $validated['image_path'] = $this->storeImage($request->file('image'));
        }

        $profileGalleryImage->update($validated);

        return redirect()->route('admin.profile-gallery-images.index');
    }

    public function destroy(ProfileGalleryImage $profileGalleryImage): RedirectResponse
    {
        $this->deleteImage($profileGalleryImage->image_path);
        $profileGalleryImage->delete();

        return redirect()->route('admin.profile-gallery-images.index');
    }

    private function storeImage($image): string
    {
        $directory = public_path('images/profile-gallery');
        File::ensureDirectoryExists($directory);

        $filename = Str::uuid().'.'.$image->getClientOriginalExtension();
        $image->move($directory, $filename);

        return 'images/profile-gallery/'.$filename;
    }

    private function deleteImage(?string $imagePath): void
    {
        if ($imagePath && File::exists(public_path($imagePath))) {
            File::delete(public_path($imagePath));
        }
    }
}