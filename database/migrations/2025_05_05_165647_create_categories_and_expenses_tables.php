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
        // Create categories table first
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('color')->default('#3b82f6'); // Default blue color
            $table->string('icon')->nullable();
            $table->timestamps();
            
            // Make name unique per user
            $table->unique(['user_id', 'name']);
        });
        
        // Create expenses table with reference to categories
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('description');
            $table->date('date');
            $table->text('notes')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->string('recurring_frequency')->nullable(); // daily, weekly, monthly, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tables in reverse order (expenses depends on categories)
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('categories');
    }
};
