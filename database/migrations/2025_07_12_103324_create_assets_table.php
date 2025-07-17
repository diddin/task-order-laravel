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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->timestamp('validation_date')->nullable();
            $table->timestamp('data_collection_time')->nullable();
            $table->string('location')->nullable();
            $table->string('code');
            $table->string('name');
            $table->string('label');
            $table->string('object_type')->nullable();
            $table->string('construction_location')->nullable();
            $table->string('potential_problem')->nullable();
            $table->string('improvement_recomendation')->nullable();
            $table->string('detail_improvement_recomendation')->nullable();
            $table->string('pop')->nullable();
            $table->string('olt')->nullable();
            $table->integer('number_of_ports')->default(0);
            $table->integer('number_of_registered_ports')->default(0);
            $table->integer('number_of_registered_labels')->default(0);
            
            $table->foreignId('network_id')->constrained()->unique()->onDelete('cascade');
            // unique() karena 1 network hanya punya 1 asset (one-to-one)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
