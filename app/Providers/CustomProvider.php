<?php

namespace App\Providers;

use App\Services\PostService;
use Illuminate\Support\ServiceProvider;

class CustomProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // $this->app->bind('post', function($app){
        //     return new \App\Services\PostService();
        // });

        $this->app->singleton('post',function($app){ // singleton means we can create only one object through it and use it only once
            return new PostService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
