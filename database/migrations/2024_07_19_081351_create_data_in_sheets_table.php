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
        Schema::create('data_in_sheets', function (Blueprint $table) {
            $table->id();

            $table->string('FullName')->nullable();
            // $table->string('LastName')->nullable();
            $table->string('Location')->nullable();
            $table->LongText('Bio')->nullable();
            $table->string('WhatsApp')->nullable();
            $table->string('FaceTime')->nullable();
            $table->string('LinkedInURL')->nullable();
            $table->string('Email');
            $table->string('Email2')->nullable();
            $table->text('JobOffers')->nullable();
            // $table->text('Availability')->nullable();
            // $table->string('Specialty')->nullable();
            $table->string('NameAlias');
            // $table->string('LastAlias');
            $table->LongText('BioAlias');
            $table->string('Availability')->nullable();
            // $table->text('Advice')->nullable();
            // $table->text('AdviceCredentials')->nullable();
            $table->string('TermsConfirm')->nullable();
            $table->longText('PhotoAI')->nullable();           
            $table->string('Resume')->nullable();
            $table->timestamps();
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_in_sheets');
    }
};
