<?php

namespace App\Providers;


use OpenAI;
use OpenAI\Client as OpenAIClient;

use Illuminate\Support\ServiceProvider;

class OpenAIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    // public function register(): void
    // {
    //     $this->app->singleton(OpenAIClient::class, function ($app) {
    //         return \OpenAI::client(env('OPENAI_API_KEY'));
    //     });
    // }
    public function register()
    {
        
             $this->app->singleton(OpenAIClient::class, function ($app) {
           
            return \OpenAI::client(env('OPENAI_API_KEY'));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
