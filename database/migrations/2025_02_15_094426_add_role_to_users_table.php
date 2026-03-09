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
        Schema::table('users', function (Blueprint $table) {
            // Using DB::statement for ENUM columns is problematic in sqlite
            // For sqlite, enum columns are text. We'll skip the modification if it's sqlite.
            if (\DB::getDriverName() !== 'sqlite') {
                \DB::statement("ALTER TABLE users MODIFY role ENUM('engineer', 'secretary', 'admin', 'accountant') NOT NULL DEFAULT 'engineer'");
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (\DB::getDriverName() !== 'sqlite') {
                \DB::statement("ALTER TABLE users MODIFY role ENUM('engineer', 'secretary', 'admin') NOT NULL DEFAULT 'engineer'");
            }
        });
    }
};
