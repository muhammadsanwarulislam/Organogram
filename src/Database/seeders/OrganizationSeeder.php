<?php
namespace Sanwarul\Organogram\Database\Seeders;

use Sanwarul\Organogram\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    public function run()
    {
        // Create Ministry of Public Administration
        $ministry = Organization::create([
            'name' => 'Ministry of Public Administration',
            'code' => 'MOPA',
            'type' => 'ministry',
            'layer' => 'ministry',
            'origin' => 'central',
            'metadata' => json_encode([
                'address' => 'Bangladesh Secretariat, Dhaka',
                'phone' => '02-12345678',
                'email' => 'mopa@mopa.gov.bd'
            ]),
        ]);
        $ministry->setTranslation('name', 'bn', 'জনপ্রশাসন মন্ত্রণালয়');
        $ministry->setTranslation('code', 'bn', 'জনপ্রশাসন মন্ত্রণালয়');
        $ministry->setTranslation('type', 'bn', 'মন্ত্রণালয়');

        // Create Public Administration Division
        $division = Organization::create([
            'name' => 'Public Administration Division',
            'code' => 'PAD',
            'type' => 'division',
            'layer' => 'division',
            'origin' => 'central',
            'parent_id' => $ministry->id,
            'metadata' => json_encode([
                'address' => 'Bangladesh, Dhaka',
                'phone' => '02-87654321',
                'email' => 'pad@mopa.gov.bd'
            ]),
        ]);
        $division->setTranslation('name', 'bn', 'জনপ্রশাসন বিভাগ');

        // Create Chief Information Commissioner Office
        $office = Organization::create([
            'name' => 'Chief Information Commissioner Office',
            'code' => 'CICO',
            'type' => 'office',
            'layer' => 'office',
            'origin' => 'independent',
            'parent_id' => $division->id,
            'metadata' => json_encode([
                'address' => 'Dhaka',
                'phone' => '02-11223344',
                'email' => 'cico@mopa.gov.bd'
            ])
        ]);
        $office->setTranslation('name', 'bn', 'প্রধান তথ্য কমিশনারের কার্যালয়');

        // Create Ministry of Law
        $lawMinistry = Organization::create([
            'name' => 'Ministry of Law, Justice and Parliamentary Affairs',
            'code' => 'LAW',
            'type' => 'ministry',
            'layer' => 'ministry',
            'origin' => 'central',
            'metadata' => json_encode([
                'address' => 'Bangladesh Secretariat, Dhaka 1000',
                'phone' => '02-58315000',
                'email' => 'moljpa@mopa.gov.bd'
            ]),
        ]);
        $lawMinistry->setTranslation('name', 'bn', 'আইন, বিচার ও সংসদ বিষয়ক মন্ত্রণালয়');

        // Create National Human Rights Commission
        $nhrc = Organization::create([
            'name' => 'National Human Rights Commission',
            'code' => 'NHRC',
            'type' => 'office',
            'layer' => 'commission',
            'origin' => 'independent',
            'parent_id' => $lawMinistry->id,
            'metadata' => json_encode([
                'address' => 'National Human Rights Commission Building, 1, Segun Bagicha, Dhaka 1000',
                'phone' => '02-58314418',
                'email' => 'info@nhrc.gov.bd'
            ]),
        ]);
        $nhrc->setTranslation('name', 'bn', 'জাতীয় মানবাধিকার কমিশন');
    
    }
}