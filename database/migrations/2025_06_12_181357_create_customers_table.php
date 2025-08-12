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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // nama instansi / perusahaan
            $table->string('contact_person')->nullable(); // nama orang yang bisa dihubungi
            $table->text('address')->nullable();
            $table->string('network_number')->nullable();
            $table->string('pic')->nullable();
            $table->text('technical_data');
            
            $table->enum('category', ['akses', 'backbone'])->default('akses');
            $table->enum('cluster', ['BWA', 'SAST', 'CDA', 'BDA', 'SEOA', 'NEA'])->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
