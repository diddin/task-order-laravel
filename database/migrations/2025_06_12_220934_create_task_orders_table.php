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
        Schema::create('task_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->text('status');

            // Kolom tambahan
            $table->string('image')->nullable();         // Path gambar (nullable)
            $table->decimal('latitude', 10, 7);          // Latitude (presisi umum GPS)
            $table->decimal('longitude', 10, 7);         // Longitude

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_orders');
    }
};