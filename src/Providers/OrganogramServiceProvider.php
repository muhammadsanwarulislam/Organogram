<?php
declare(strict_types=1);

namespace Sanwarul\Organogram\Providers;

use Illuminate\Support\ServiceProvider;
use Sanwarul\Organogram\Http\Middleware\SetLocalization;
use Sanwarul\Organogram\Console\Commands\InstallOrganogram;
use Sanwarul\Organogram\Console\Commands\SeedOrganogramData;

class OrganogramServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Merge package configuration
        $this->mergeConfigFrom(
            __DIR__.'/../config/organogram.php', 'organogram'
        );

        $this->app['router']->aliasMiddleware('set.localization', SetLocalization::class);

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');
        
        // Publish migrations
        $this->publishes([
            __DIR__.'/../Database/migrations' => database_path('migrations'),
        ], 'organogram-migrations');

        //Publish seeders
        $this->publishes([
            __DIR__.'/../Database/seeders' => database_path('seeders'),
        ], 'organogram-seeders');
        
    }

    public function register()
    {   
        $this->app->bind('organogram', function() {
            return new \Sanwarul\Organogram\Services\OrganogramService();
        });
        
        // Register console commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                SeedOrganogramData::class,
                InstallOrganogram::class
            ]);
        }
    }
}