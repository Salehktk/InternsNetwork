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
        Schema::create('coach_googlesheets', function (Blueprint $table) {
            $table->id();

            $table->string('full_name')->nullable(); //
            $table->text('specialties')->nullable(); //
            $table->string('category')->nullable(); //
            $table->text('bio')->nullable(); //
            $table->string('location')->nullable(); //
            $table->string('fx')->nullable(); //
            $table->string('pay')->nullable(); //
            $table->string('how_good')->nullable(); //
            $table->string('responsive')->nullable(); //
            $table->string('on_whatsapp')->nullable(); //
            $table->string('linkedin_url')->nullable(); //
            $table->string('email')->nullable(); //
            $table->string('email2')->nullable(); //
            $table->string('whatsapp')->nullable(); //
            $table->string('facetime_imessage')->nullable(); //
            $table->string('terms_confirmed')->nullable(); //
            $table->text('payment_details')->nullable(); //
            $table->string('zelle_paypal_venmo')->nullable();  //
            $table->string('sort_code')->nullable(); //
            $table->string('account_number')->nullable(); //
            $table->string('account_holder')->nullable(); //
            $table->text('name_alias')->nullable(); //
            $table->text('bio_alias')->nullable(); //
            $table->string('job_offers')->nullable(); //
            $table->string('photo_ai')->nullable(); //
            $table->string('resume')->nullable(); //
            $table->text('availability')->nullable();//
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coach_googlesheets');
    }
};
