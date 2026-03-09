<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_name',
        'transaction_code',
        'client_name',
        'total_amount',
        'installment_1',
        'installment_2',
        'installment_3',
        'paid_amount',
        'remaining_amount',
    ];

   
}
