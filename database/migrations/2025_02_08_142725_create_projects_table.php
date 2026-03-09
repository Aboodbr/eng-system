<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('file_path'); // مسار الملف
        $table->foreignId('sender_id')->constrained('users')->onDelete('cascade'); // المرسل (سكرتير أو مهندس)
        $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade'); // المستقبل (مهندس)
        $table->timestamps();
    });
    
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
