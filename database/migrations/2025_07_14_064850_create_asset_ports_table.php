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
        Schema::create('asset_ports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asset_id')->constrained()->onDelete('cascade');
            $table->string('port');    // contoh: "PORT 1", "P2", dst
            $table->foreignId('jumper_id')->nullable()->constrained('asset_ports')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_ports');
    }
};
