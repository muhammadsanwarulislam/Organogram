<?php
declare(strict_types=1);

namespace Sanwarul\Organogram\Console\Commands;

use Illuminate\Console\Command;
use Sanwarul\Organogram\Database\Seeders\DatabaseSeeder as OrganogramSeeder;

class SeedOrganogramData extends Command
{
    protected $signature = 'organogram:seed';
    protected $description = 'Seed the organogram with sample data';

    public function handle()
    {
        $this->info('Seeding organogram data...');
        
        $seeder = new OrganogramSeeder();
        $seeder->run();
        
        $this->info('Organogram data seeded successfully!');
    }
}