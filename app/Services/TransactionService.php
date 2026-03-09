<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService
{
    /**
     * Store a newly created transaction in storage.
     *
     * @param array $data
     * @return Transaction
     */
    public function storeTransaction(array $data): Transaction
    {
        $installment1 = floatval($data['installment_1'] ?? 0);
        $installment2 = floatval($data['installment_2'] ?? 0);
        $installment3 = floatval($data['installment_3'] ?? 0);

        $paidAmount = $installment1 + $installment2 + $installment3;
        $remainingAmount = $data['total_amount'] - $paidAmount;

        return Transaction::create([
            'transaction_name' => $data['transaction_name'],
            'transaction_code' => $data['transaction_code'],
            'client_name' => $data['client_name'],
            'total_amount' => $data['total_amount'],
            'installment_1' => $installment1,
            'installment_2' => $installment2,
            'installment_3' => $installment3,
            'paid_amount' => $paidAmount,
            'remaining_amount' => $remainingAmount,
        ]);
    }

    /**
     * Update an existing transaction in storage.
     *
     * @param Transaction $transaction
     * @param array $data
     * @return bool
     */
    public function updateTransaction(Transaction $transaction, array $data): bool
    {
        $installment1 = floatval($data['installment_1'] ?? 0);
        $installment2 = floatval($data['installment_2'] ?? 0);
        $installment3 = floatval($data['installment_3'] ?? 0);

        $paidAmount = $installment1 + $installment2 + $installment3;
        $remainingAmount = $data['total_amount'] - $paidAmount;

        return $transaction->update([
            'transaction_name' => $data['transaction_name'],
            'transaction_code' => $data['transaction_code'],
            'client_name' => $data['client_name'],
            'total_amount' => $data['total_amount'],
            'installment_1' => $installment1,
            'installment_2' => $installment2,
            'installment_3' => $installment3,
            'paid_amount' => $paidAmount,
            'remaining_amount' => $remainingAmount,
        ]);
    }
}
