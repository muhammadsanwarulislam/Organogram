<?php
namespace Sanwarul\Organogram\Database\Seeders;

use Sanwarul\Organogram\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    public function run()
    {
        // Create a sample ministry
        $ministry = Organization::create([
            'name' => 'Ministry of Public Administration',
            'code' => 'MOPA',
            'type' => 'ministry',
            'address' => 'Bangladesh Secretariat, Dhaka',
            'phone' => '02-12345678',
            'email' => 'mopa@mopa.gov.bd',
        ]);

        $ministry->setTranslation('name', 'bn', 'জনপ্রশাসন মন্ত্রণালয়');

        // Create a division under the ministry
        $division = Organization::create([
            'name' => 'Public Administration Division',
            'code' => 'PAD',
            'type' => 'division',
            'parent_id' => $ministry->id,
            'address' => 'Bangladesh Secretariat, Dhaka',
            'phone' => '02-87654321',
            'email' => 'pad@mopa.gov.bd',
        ]);

        $division->setTranslation('name', 'bn', 'জনপ্রশাসন বিভাগ');

        // Create an office under the division
        $office = Organization::create([
            'name' => 'Chief Information Commissioner Office',
            'code' => 'CICO',
            'type' => 'office',
            'parent_id' => $division->id,
            'address' => 'Dhaka',
            'phone' => '02-11223344',
            'email' => 'cico@mopa.gov.bd',
        ]);

        $office->setTranslation('name', 'bn', 'প্রধান তথ্য কমিশনারের কার্যালয়');
    }
}