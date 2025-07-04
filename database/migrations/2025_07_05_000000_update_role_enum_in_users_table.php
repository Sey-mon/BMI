<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        // For MySQL
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'user', 'nutritionist') NOT NULL DEFAULT 'user'");
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        // For MySQL
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'user') NOT NULL DEFAULT 'user'");
    }
};
