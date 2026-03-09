<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 2025_02_15_110736_create_transactions_table.php already creates transactions
        // We only need to add missing installments to it.
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('installment_1', 10, 2)->default(0);
            $table->decimal('installment_2', 10, 2)->default(0);
            $table->decimal('installment_3', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['installment_1', 'installment_2', 'installment_3']);
        });
    }
};
