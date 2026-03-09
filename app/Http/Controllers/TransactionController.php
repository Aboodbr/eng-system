<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }
    public function index()
    {
        $transactions = Transaction::paginate(10);
        return view('dashboard.accountant', compact('transactions'));
    }

    public function create()
    {
        return view('dashboard.transaction_create');
    }

    public function store(StoreTransactionRequest $request)
    {
        $this->transactionService->storeTransaction($request->validated());

        return redirect()->route('accountant')->with('success', 'تمت إضافة المعاملة بنجاح!');
    }
    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('dashboard.edit-transactions', compact('transaction'));
    }

    public function update(UpdateTransactionRequest $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $this->transactionService->updateTransaction($transaction, $request->validated());

        return redirect()->route('accountant')->with('success', 'تم تعديل المعاملة بنجاح!');
    }

    

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json(['success' => true]);
    }
}

