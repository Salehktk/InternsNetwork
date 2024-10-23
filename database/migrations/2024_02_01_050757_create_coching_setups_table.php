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
        Schema::create('coching_setups', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->string('userEmails')->nullable();
            $table->longText('interviewDetails');
            $table->string('client');
            $table->string('deadline');
            $table->string('service');
            $table->string('status')->default(0);
            $table->longText('setupNotes');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coching_setups');
    }
};
