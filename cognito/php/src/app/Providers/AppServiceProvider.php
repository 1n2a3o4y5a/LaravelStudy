<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extendImplicit('cognito_user_unique', 'App\Validators\CognitoUserUniqueValidator@validate');
    }
}
