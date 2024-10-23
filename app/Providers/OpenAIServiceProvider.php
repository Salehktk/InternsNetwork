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
        // $apiKey = 'sk-proj-ur0F5y9A4ST4GnRA0hTtT3BlbkFJZx9u3OFRep0seUSXC1oj'; 
        // $organizationId = 'org-hlbV1iRSSYEl2MGDIe8vyPNy'; // Replace with your actual organization ID
          
        // $this->app->singleton(OpenAIClient::class, function ($app) use ($apiKey, $organizationId) {
        //     return OpenAIClient::factory()
        //         ->setApiKey($apiKey)
        //         ->setOrganization($organizationId);
        // });
        // dd(env('OPENAI_API_KEY'));
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
