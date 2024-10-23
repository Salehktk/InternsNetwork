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
        Schema::create('coach_service', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coach_id');
            $table->unsignedBigInteger('service_id');
            $table->timestamps();

            $table->foreign('coach_id')->references('id')->on('coach_googlesheets')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('service_googlesheets')->onDelete('cascade');
         
            $table->index('coach_id');
            $table->index('service_id');
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coach_service');
    }
};
