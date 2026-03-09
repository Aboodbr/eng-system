<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return view('dashboard.accountant', compact('transactions'));
    }

    public function create()
    {
        return view('dashboard.transaction_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_name' => 'required|string|max:255',
            'transaction_code' => 'required|string|max:50|unique:transactions',
            'client_name' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'installment_1' => 'nullable|numeric|min:0',
            'installment_2' => 'nullable|numeric|min:0',
            'installment_3' => 'nullable|numeric|min:0',
        ]);

        $installment1 = floatval($request->input('installment_1', 0));
$installment2 = floatval($request->input('installment_2', 0));
$installment3 = floatval($request->input('installment_3', 0));

        $paidAmount = $installment1 + $installment2 + $installment3;
        $remainingAmount = $request->total_amount - $paidAmount;
        
        Transaction::create([
            'transaction_name' => $request->transaction_name,
            'transaction_code' => $request->transaction_code,
            'client_name' => $request->client_name,
            'total_amount' => $request->total_amount,
            'installment_1' => $installment1,
            'installment_2' => $installment2,
            'installment_3' => $installment3,
            'paid_amount' => $paidAmount,
            'remaining_amount' => $remainingAmount,
        ]);

        return redirect()->route('accountant')->with('success', 'تمت إضافة المعاملة بنجاح!');
    }
    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('dashboard.edit-transactions', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'transaction_name' => 'required|string|max:255',
            'transaction_code' => 'required|string|max:255|unique:transactions,transaction_code,' . $id,
            'client_name' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'installment_1' => 'nullable|numeric|min:0',
            'installment_2' => 'nullable|numeric|min:0',
            'installment_3' => 'nullable|numeric|min:0',
        ]);

        // العثور على المعاملة
        $transaction = Transaction::findOrFail($id);

        // احتساب المبلغ المدفوع تلقائيًا (مجموع الأقساط)
        $paid_amount = ($request->installment_1 ?? 0) + 
                       ($request->installment_2 ?? 0) + 
                       ($request->installment_3 ?? 0);

        // احتساب المبلغ المتبقي تلقائيًا
        $remaining_amount = $request->total_amount - $paid_amount;

        // تحديث المعاملة
        $transaction->update([
            'transaction_name' => $request->transaction_name,
            'transaction_code' => $request->transaction_code,
            'client_name' => $request->client_name,
            'total_amount' => $request->total_amount,
            'installment_1' => $request->installment_1 ?? 0,
            'installment_2' => $request->installment_2 ?? 0,
            'installment_3' => $request->installment_3 ?? 0,
            'paid_amount' => $paid_amount,
            'remaining_amount' => $remaining_amount,
        ]);

        return redirect()->route('accountant')->with('success', 'تم تعديل المعاملة بنجاح!');
    }

    

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json(['success' => true]);
    }
}

