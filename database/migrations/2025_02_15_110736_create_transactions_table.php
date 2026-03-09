<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_name'); 
            $table->string('transaction_code')->unique(); 
            $table->string('client_name'); 
            $table->decimal('total_amount', 10, 2); 
            $table->decimal('paid_amount', 10, 2)->default(0); 
            $table->decimal('remaining_amount', 10, 2)->virtualAs('total_amount - paid_amount'); // المتبقي (حقل افتراضي)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
