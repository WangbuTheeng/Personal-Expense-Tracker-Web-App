<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->string('type')->default('expense')->after('category_id');
        });

        // Update existing entries - positive amounts are income, negative are expenses
        DB::statement("UPDATE expenses SET type = 'income' WHERE amount > 0");
        DB::statement("UPDATE expenses SET type = 'expense' WHERE amount <= 0");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
