<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\BudgetTransaction;
use App\Models\DocumentRequest;
use App\Models\DocumentType;
use App\Models\ProfileGalleryImage;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

    public function budgetTransparency(Request $request): View
    {
        $year     = $request->input('year', now()->year);
        $category = $request->input('category');
        $type     = $request->input('type'); // 'income' | 'expense' | null

        $query = BudgetTransaction::query()
            ->whereYear('transaction_date', $year);

        if ($category) {
            $query->where('category', $category);
        }
        if ($type) {
            $query->where('type', $type);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->paginate(15)->withQueryString();

        // Aggregates for summary cards
        $totalIncome  = BudgetTransaction::whereYear('transaction_date', $year)
            ->where('type', 'income')->sum('amount');
        $totalExpense = BudgetTransaction::whereYear('transaction_date', $year)
            ->where('type', 'expense')->sum('amount');

        // Data for bar chart (per month)
        $monthlyData = BudgetTransaction::whereYear('transaction_date', $year)
            ->selectRaw('MONTH(transaction_date) as month, type, SUM(amount) as total')
            ->groupBy('month', 'type')
            ->orderBy('month')
            ->get()
            ->groupBy('month');

        // Category breakdown
        $categoryBreakdown = BudgetTransaction::whereYear('transaction_date', $year)
            ->selectRaw('category, type, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('category', 'type')
            ->orderByDesc('total')
            ->get();

        $categories   = BudgetTransaction::distinct()->pluck('category')->sort()->values();
        $years        = BudgetTransaction::selectRaw('YEAR(transaction_date) as year')
            ->distinct()->orderByDesc('year')->pluck('year');

        return view('site.budget-transparency', compact(
            'transactions', 'year', 'category', 'type',
            'totalIncome', 'totalExpense', 'monthlyData',
            'categoryBreakdown', 'categories', 'years'
        ));
    }

    public function documents(Request $request): View
    {
        $documentTypes = DocumentType::all();
        $track = $request->query('track');
        $trackedRequest = null;

        if ($track) {
            $trackedRequest = DocumentRequest::where('tracking_code', $track)->first();
        }

        return view('site.documents', compact('documentTypes', 'trackedRequest', 'track'));
    }

    public function storeDocument(Request $request)
    {
        $validated = $request->validate([
            'document_type_id' => 'required|exists:document_types,id',
            'applicant_name'   => 'required|string|max:255',
            'applicant_nik'    => 'required|string|max:20',
            'applicant_phone'  => 'required|string|max:20',
            'purpose'          => 'required|string',
        ]);

        $validated['request_number'] = 'REQ-' . date('Ymd') . '-' . strtoupper(Str::random(5));
        $validated['tracking_code']  = strtoupper(Str::random(10));
        
        $documentRequest = DocumentRequest::create($validated);

        return redirect()->route('documents', ['track' => $documentRequest->tracking_code])
            ->with('success', 'Permohonan surat berhasil dikirim. Harap simpan kode pelacakan Anda: ' . $documentRequest->tracking_code);
    }
}
