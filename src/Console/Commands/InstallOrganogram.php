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
        $includeFrontend = $this->choice(
            'What would you like to install?',
            ['API only', 'API + Frontend'],
            0
        );

        $this->call('migrate');

        $this->publishMigrationsAndSeeders();

        $this->seedData();

        $this->publishModels();

        if ($includeFrontend === 'API + Frontend') {
            $this->installFrontend();
        }

        $this->info('Installation completed successfully!');
    }

    protected function publishMigrationsAndSeeders()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Sanwarul\Organogram\Providers\OrganogramServiceProvider',
            '--tag' => 'organogram-migrations'
        ]);

        $this->call('vendor:publish', [
            '--provider' => 'Sanwarul\Organogram\Providers\OrganogramServiceProvider',
            '--tag' => 'organogram-seeders'
        ]);
    }

    protected function seedData()
    {
        $this->call('db:seed', [
            '--class' => 'Sanwarul\Organogram\Database\Seeders\DatabaseSeeder'
        ]);
    }
    protected function installFrontend()
    {
        $this->info('Setting up frontend...');

        $frontendPath = base_path('organogram-frontend');
        if (!File::exists($frontendPath)) {
            File::makeDirectory($frontendPath);
        }

        File::copyDirectory(__DIR__ . '/../../frontend', $frontendPath);

        $this->info('Frontend installed successfully!');
        $this->info('To run the frontend:');
        $this->info('1. cd organogram-frontend');
        $this->info('2. npm install');
        $this->info('3. create a local.env file with your environment variables');
        $this->info('4. npm run dev');
    }

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

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        foreach ($models as $stubName => $fileName) {
            $stubPath = __DIR__ . '/../../stubs/Models/' . $stubName . '.stub';
            $destination = $destinationPath . '/' . $fileName;

            if (File::exists($destination) && !$this->option('force')) {
                $this->error("Model {$fileName} already exists! Use --force to overwrite.");
                continue;
            }

            if (File::exists($stubPath)) {

                $content = File::get($stubPath);
                $content = str_replace('{{ class }}', $stubName, $content);
                File::put($destination, $content);

                $this->info("Published model: {$fileName}");
            } else {
                $this->error("Stub file not found: {$stubPath}");
            }
        }
    }
}
