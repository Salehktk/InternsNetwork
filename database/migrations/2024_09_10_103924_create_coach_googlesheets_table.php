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
            $table->longText('specialties')->nullable(); //
            $table->string('category')->nullable(); //
            $table->longText('bio')->nullable(); //
            $table->longText('location')->nullable(); //
            $table->longText('fx')->nullable(); //
            $table->string('pay')->nullable(); //
            $table->longText('how_good')->nullable(); //
            $table->longText('responsive')->nullable(); //
            $table->string('on_whatsapp')->nullable(); //
            $table->string('linkedin_url')->nullable(); //
            $table->string('email')->nullable(); //
            $table->string('email2')->nullable(); //
            $table->string('whatsapp')->nullable(); //
            $table->longText('facetime_imessage')->nullable(); //
            $table->string('terms_confirmed')->nullable(); //
            $table->text('payment_details')->nullable(); //
            $table->longText('zelle_paypal_venmo')->nullable();  //
            $table->string('sort_code')->nullable(); //
            $table->string('account_number')->nullable(); //
            $table->string('account_holder')->nullable(); //
            $table->longText('name_alias')->nullable(); //
            $table->text('bio_alias')->nullable(); //
            $table->longText('job_offers')->nullable(); //
            $table->longText('photo_ai')->nullable(); //
            $table->longText('resume')->nullable(); //
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
