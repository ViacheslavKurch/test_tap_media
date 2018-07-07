<?php

namespace App\Providers;

use App\Services\BadDomainService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Repositories\ClickRepository;
use App\Repositories\BadDomainRepository;
use App\Services\ClickService;
use App\Services\ResponseService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClickService::class, function($app) {
            return new ClickService(
                new ClickRepository($app['em']),
                new BadDomainRepository($app['em'])
            );
        });

        $this->app->bind(ResponseService::class, function($app) {
            return new ResponseService(new ClickRepository($app['em']));
        });

        $this->app->bind(BadDomainService::class, function($app) {
            return new BadDomainService(new BadDomainRepository($app['em']));
        });
    }
}
