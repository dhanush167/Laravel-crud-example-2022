<?php

namespace App\Providers;

use App\Services\BiodataService;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(BiodataService::class,function ($app){
            return new BiodataService(
                config('custom.infant'),
                config('custom.toddler'),
                config('custom.preschooler'),
                config('custom.child'),
                config('custom.teenager_or_adolescent'),
                config('custom.young_adult'),
                config('custom.middle_aged_adult'),
                config('custom.senior_citizen_elderly')
            );
        });
    }
}
