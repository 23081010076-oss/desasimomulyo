<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BudgetTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BudgetTransactionAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.budgets.index', ['transactions' => BudgetTransaction::latest()->paginate(10)]);
    }

    public function create(): View
    {
        return view('admin.budgets.form', ['transaction' => new BudgetTransaction()]);
    }

    public function store(Request $request): RedirectResponse
    {
        BudgetTransaction::create($request->only(['title', 'category', 'type', 'amount', 'transaction_date', 'notes']));

        return redirect()->route('admin.budgets.index');
    }

    public function edit(BudgetTransaction $budget): View
    {
        return view('admin.budgets.form', ['transaction' => $budget]);
    }

    public function update(Request $request, BudgetTransaction $budget): RedirectResponse
    {
        $budget->update($request->only(['title', 'category', 'type', 'amount', 'transaction_date', 'notes']));

        return redirect()->route('admin.budgets.index');
    }

    public function destroy(BudgetTransaction $budget): RedirectResponse
    {
        $budget->delete();

        return redirect()->route('admin.budgets.index');
    }
}
