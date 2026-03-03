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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->enum('category', [
                'vehicles',
                'home_garden',
                'electronics',
                'clothing',
                'sports',
                'toys_games',
                'books',
                'furniture',
                'music',
                'other'
            ]);
            $table->enum('condition', ['new', 'like_new', 'good', 'fair', 'poor']);
            $table->string('location')->nullable();
            $table->json('images')->nullable();
            $table->enum('status', ['active', 'sold', 'inactive'])->default('active');
            $table->boolean('featured')->default(false);
            $table->timestamps();

            $table->index(['category', 'status']);
            $table->index(['user_id', 'status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};