<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MadWeb\Robots\RobotsFacade;

use App\{
    Job
};

use App\Observers\{
    JobObserver
};

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
        
        RobotsFacade::setShouldIndexCallback(function () {
            return true;
        });

        Job::observe(JobObserver::class);
    }
}
