<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\BudgetTransaction;
use App\Models\DocumentRequest;
use App\Models\HotlineMessage;
use App\Models\Product;
use App\Models\Report;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'reports' => Report::count(),
                'emergency' => Report::where('status', 'EMERGENCY')->count(),
                'documents' => DocumentRequest::count(),
                'hotline' => HotlineMessage::count(),
                'articles' => Article::count(),
                'budget' => BudgetTransaction::count(),
                'products' => Product::count(),
            ],
            'recentReports' => Report::latest()->take(5)->get(),
        ]);
    }
}
