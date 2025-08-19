<?php
<<<<<<< HEAD
=======

>>>>>>> d0767ef1debaab9034c94637e64674374542e4fb
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
<<<<<<< HEAD
        
        // Ask if user wants frontend
=======

>>>>>>> d0767ef1debaab9034c94637e64674374542e4fb
        $includeFrontend = $this->choice(
            'What would you like to install?',
            ['API only', 'API + Frontend'],
            0
        );
<<<<<<< HEAD
        
=======

>>>>>>> d0767ef1debaab9034c94637e64674374542e4fb
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
<<<<<<< HEAD
        
        if ($includeFrontend === 'API + Frontend') {
            $this->installFrontend();
        }
        
        $this->info('Installation completed successfully!');
    }
    
    protected function installFrontend()
    {
        $this->info('Setting up frontend...');
        
=======

        $this->publishModels();

        if ($includeFrontend === 'API + Frontend') {
            $this->installFrontend();
        }

        $this->info('Installation completed successfully!');
    }

    protected function installFrontend()
    {
        $this->info('Setting up frontend...');

>>>>>>> d0767ef1debaab9034c94637e64674374542e4fb
        // Create frontend directory if it doesn't exist
        $frontendPath = base_path('organogram-frontend');
        if (!File::exists($frontendPath)) {
            File::makeDirectory($frontendPath);
        }
<<<<<<< HEAD
        
        // Copy frontend files from package to project
        File::copyDirectory(__DIR__.'/../../frontend', $frontendPath);
        
        // Update .env file with API URL
        $this->updateEnvFile();
        
=======

        // Copy frontend files from package to project
        File::copyDirectory(__DIR__ . '/../../frontend', $frontendPath);

>>>>>>> d0767ef1debaab9034c94637e64674374542e4fb
        $this->info('Frontend installed successfully!');
        $this->info('To run the frontend:');
        $this->info('1. cd organogram-frontend');
        $this->info('2. npm install');
        $this->info('3. create a local.env file with your environment variables');
        $this->info('4. npm run dev');
    }
<<<<<<< HEAD
    
    protected function updateEnvFile()
    {
        $envPath = base_path('.env');
        $envContent = File::get($envPath);
        $envContent = str_replace('APP_URL=http://localhost', 'APP_URL=http://localhost/organogram-frontend', $envContent);
        File::put($envPath, $envContent);
    }
}
=======

    // protected function checkMigrations()
    // {
    //     $this->info('Checking for existing migrations...');
    //     $migrationsPath = database_path('migrations');

    //     if (File::exists($migrationsPath)) {
    //         $this->info('Migrations already exist. Skipping migration step.');
    //     } else {
    //         $this->info('No migrations found. Proceeding with migration.');
    //         $this->call('migrate');
    //     }
    // }

    // protected function checkSeeders()
    // {
    //     $this->info('Checking for existing seeders...');
    //     $seedersPath = database_path('seeders');

    //     if (File::exists($seedersPath)) {
    //         $this->info('Seeders already exist. Skipping seeder step.');
    //     } else {
    //         $this->info('No seeders found. Proceeding with seeding.');
    //         $this->call('db:seed', [
    //             '--class' => 'Sanwarul\Organogram\Database\Seeders\DatabaseSeeder'
    //         ]);
    //     }
    // }

    // protected function publishMigrations()
    // {
    //     $this->info('Publishing migrations...');
    //     $this->call('vendor:publish', [
    //         '--provider' => 'Sanwarul\Organogram\Providers\OrganogramServiceProvider',
    //         '--tag' => 'organogram-migrations'
    //     ]);
    //     $this->info('Migrations published successfully!');
    // }

    // protected function publishSeeders()
    // {
    //     $this->info('Publishing seeders...');
    //     $this->call('vendor:publish', [
    //         '--provider' => 'Sanwarul\Organogram\Providers\OrganogramServiceProvider',
    //         '--tag' => 'organogram-seeders'
    //     ]);
    //     $this->info('Seeders published successfully!');
    // }

    protected function publishModels()
    {
        $this->info('Publishing models...');

        $models = [
            'Organization'  => 'Organization.php',
            'Department'    => 'Department.php',
            'Employee'      => 'Employee.php',
            'Position'      => 'Position.php',
            'Translation'   => 'Translation.php'
        ];

        $destinationPath = app_path('Models');

        // Create Models directory if it doesn't exist
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        foreach ($models as $stubName => $fileName) {
            $stubPath = __DIR__ . '/../../stubs/Models/' . $stubName . '.stub';
            $destination = $destinationPath . '/' . $fileName;

            // Check if file already exists
            if (File::exists($destination) && !$this->option('force')) {
                $this->error("Model {$fileName} already exists! Use --force to overwrite.");
                continue;
            }

            if (File::exists($stubPath)) {
                // Get stub content
                $content = File::get($stubPath);

                // Replace class name if needed
                $content = str_replace('{{ class }}', $stubName, $content);

                // Save to destination
                File::put($destination, $content);

                $this->info("Published model: {$fileName}");
            } else {
                $this->error("Stub file not found: {$stubPath}");
            }
        }
    }
}
>>>>>>> d0767ef1debaab9034c94637e64674374542e4fb
