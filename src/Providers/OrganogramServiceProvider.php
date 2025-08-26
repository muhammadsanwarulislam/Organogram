<?php
declare(strict_types=1);

namespace Sanwarul\Organogram\Providers;

use Illuminate\Support\ServiceProvider;
use Sanwarul\Organogram\Models\Position;
use Sanwarul\Organogram\Services\Position\PositionService;
use Sanwarul\Organogram\Console\Commands\InstallOrganogram;
use Sanwarul\Organogram\Console\Commands\SeedOrganogramData;
use Sanwarul\Organogram\Repositories\Position\PositionRepository;

class OrganogramServiceProvider extends ServiceProvider
{
    public function boot()
    {
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
        $this->app->bind(PositionRepository::class, function ($app) {
            return new PositionRepository(new Position());
        });

        $this->app->bind(PositionService::class, function ($app) {
            return new PositionService($app->make(PositionRepository::class));
        });
        
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