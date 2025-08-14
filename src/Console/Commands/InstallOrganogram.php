<?php
declare(strict_types=1);

namespace Sanwarul\Organogram\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallOrganogram extends Command
{
    protected $signature = 'organogram:install';
    protected $description = 'Install the Organogram package with optional frontend';

    public function handle()
    {
        $this->info('Welcome to the Organogram Package Installation!');
        
        // Ask if user wants frontend
        $includeFrontend = $this->choice(
            'What would you like to install?',
            ['API only', 'API + Frontend'],
            0
        );
        
        // Run migrations
        $this->call('migrate');
        
        // Publish seeders
        $this->call('vendor:publish', [
            '--provider' => 'Sanwarul\Organogram\Providers\OrganogramServiceProvider',
            '--tag' => 'organogram-seeders'
        ]);
        
        // Publish migrations
        $this->call('vendor:publish', [
            '--provider' => 'Sanwarul\Organogram\Providers\OrganogramServiceProvider',
            '--tag' => 'organogram-migrations'
        ]);

        // Seed database
        $this->call('db:seed', [
            '--class' => 'Sanwarul\Organogram\Database\Seeders\DatabaseSeeder'
        ]);
        
        if ($includeFrontend === 'API + Frontend') {
            $this->installFrontend();
        }
        
        $this->info('Installation completed successfully!');
    }
    
    protected function installFrontend()
    {
        $this->info('Setting up frontend...');
        
        // Create frontend directory if it doesn't exist
        $frontendPath = base_path('organogram-frontend');
        if (!File::exists($frontendPath)) {
            File::makeDirectory($frontendPath);
        }
        
        // Copy frontend files from package to project
        File::copyDirectory(__DIR__.'/../../frontend', $frontendPath);
        
        // Update .env file with API URL
        $this->updateEnvFile();
        
        $this->info('Frontend installed successfully!');
        $this->info('To run the frontend:');
        $this->info('1. cd organogram-frontend');
        $this->info('2. npm install');
        $this->info('3. npm run dev');
    }
    
    protected function updateEnvFile()
    {
        $envPath = base_path('.env');
        $envContent = File::get($envPath);
        $envContent = str_replace('APP_URL=http://localhost', 'APP_URL=http://localhost/organogram-frontend', $envContent);
        File::put($envPath, $envContent);
    }
}