<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.articles.index', ['articles' => Article::latest()->paginate(10)]);
    }

    public function create(): View
    {
        return view('admin.articles.form', ['article' => new Article()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'required|string|max:255|unique:articles,slug',
            'excerpt'      => 'nullable|string|max:1000',
            'content'      => 'required|string',
            'image'        => [
                'nullable',
                'file',
                'max:2048',
                'mimes:jpeg,png,jpg,webp',
                'mimetypes:image/jpeg,image/png,image/webp',
            ],
            'is_published' => 'boolean',
        ]);

        $data = $request->only(['title', 'slug', 'excerpt', 'content', 'published_at']);
        $data['is_published'] = $request->has('is_published');
        
        if (!isset($data['published_at'])) {
            $data['published_at'] = $data['is_published'] ? now() : null;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->extension();
            $uploadPath = public_path('images/articles');
            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file->move($uploadPath, $filename);
            $data['featured_image'] = 'images/articles/' . $filename;
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.form', compact('article'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'required|string|max:255|unique:articles,slug,' . $article->id,
            'excerpt'      => 'nullable|string|max:1000',
            'content'      => 'required|string',
            'image'        => [
                'nullable',
                'file',
                'max:2048',
                'mimes:jpeg,png,jpg,webp',
                'mimetypes:image/jpeg,image/png,image/webp',
            ],
            'is_published' => 'boolean',
        ]);

        $data = $request->only(['title', 'slug', 'excerpt', 'content', 'published_at']);
        $data['is_published'] = $request->has('is_published');
        
        if (!isset($data['published_at']) && $data['is_published'] && !$article->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            // Hapus gambar lama secara aman
            if ($article->featured_image && file_exists(public_path($article->featured_image))) {
                @unlink(public_path($article->featured_image));
            }

            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->extension();
            $uploadPath = public_path('images/articles');
            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file->move($uploadPath, $filename);
            $data['featured_image'] = 'images/articles/' . $filename;
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        if ($article->featured_image && file_exists(public_path($article->featured_image))) {
            @unlink(public_path($article->featured_image));
        }
        
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
