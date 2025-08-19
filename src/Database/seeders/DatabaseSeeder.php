<?php
namespace Sanwarul\Organogram\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            OrganizationSeeder::class,
            DepartmentSeeder::class,
            PositionSeeder::class,
            EmployeeSeeder::class,
        ]);
    }
}