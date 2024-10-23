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
        Schema::create('admin_setups', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->longText('interviewDetails');
            $table->string('client');
            $table->string('coach');
            $table->longText('Bio');
            $table->string('deadline');
            $table->string('service');
            $table->string('coachmail');
            $table->longText('setupNotes');
            $table->string('resume');
            $table->string('batch');
            $table->string('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_setups');
    }
};
