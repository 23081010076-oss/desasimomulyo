<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\BudgetTransaction;
use App\Models\ProfileGalleryImage;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\View\View;

class PublicSiteController extends Controller
{
    private function getVillageConfig(): array
    {
        return array_merge(config('village'), Setting::pluck('value', 'key')->toArray());
    }

    public function index(): View
    {
        return view('site.home', [
            'village' => $this->getVillageConfig(),
            'articles' => Article::where('is_published', true)->latest('published_at')->take(3)->get(),
            'products' => Product::where('is_active', true)->latest()->take(4)->get(),
            'budgetTotal' => BudgetTransaction::sum('amount'),
            'budgetCount' => BudgetTransaction::count(),
        ]);
    }

    public function profile(): View
    {
        return view('site.profile', [
            'village' => $this->getVillageConfig(),
            'galleryImages' => ProfileGalleryImage::where('is_active', true)->orderBy('sort_order')->latest()->get(),
        ]);
    }

    public function map(): View
    {
        return view('site.map', [
            'village' => $this->getVillageConfig(),
        ]);
    }

    public function news()
    {
        $articles = Article::where('is_published', true)
            ->latest('published_at')
            ->paginate(9);

        return view('site.news.index', compact('articles'));
    }

    public function showNews(Article $article)
    {
        if (!$article->is_published) {
            abort(404);
        }

        return view('site.news.show', compact('article'));
    }

    public function products(): View
    {
        return view('site.products.index', [
            'village' => $this->getVillageConfig(),
            'products' => Product::where('is_active', true)->latest()->paginate(6),
        ]);
    }
}
