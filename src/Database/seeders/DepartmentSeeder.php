<?php
namespace Sanwarul\Organogram\Database\Seeders;

use Sanwarul\Organogram\Models\Organization;
use Sanwarul\Organogram\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        // Get organizations
        $ministry = Organization::where('code', 'MOPA')->first();
        $division = Organization::where('code', 'PAD')->first();
        $office = Organization::where('code', 'CICO')->first();

        // Create departments for ministry
        $ministryDept1 = Department::create([
            'organization_id' => $ministry->id,
            'name' => 'Administration Wing',
            'code' => 'MOPA-ADMIN',
        ]);

        // Add translations
        $ministryDept1->setTranslation('name', 'bn', 'প্রশাসন শাখা');

        $ministryDept2 = Department::create([
            'organization_id' => $ministry->id,
            'name' => 'Finance Wing',
            'code' => 'MOPA-FIN',
        ]);

        $ministryDept2->setTranslation('name', 'bn', 'অর্থ শাখা');

        // Create departments for division
        $divisionDept1 = Department::create([
            'organization_id' => $division->id,
            'name' => 'Policy Wing',
            'code' => 'PAD-POLICY',
        ]);

        $divisionDept1->setTranslation('name', 'bn', 'নীতি শাখা');

        $divisionDept2 = Department::create([
            'organization_id' => $division->id,
            'name' => 'Implementation Wing',
            'code' => 'PAD-IMP',
            'parent_id' => $divisionDept1->id, // Child of Policy Wing
        ]);

        $divisionDept2->setTranslation('name', 'bn', 'বাস্তবায়ন শাখা');

        // Create departments for office
        $officeDept1 = Department::create([
            'organization_id' => $office->id,
            'name' => 'Information Commission',
            'code' => 'CICO-IC',
        ]);

        $officeDept1->setTranslation('name', 'bn', 'তথ্য কমিশন');

        $officeDept2 = Department::create([
            'organization_id' => $office->id,
            'name' => 'Compliance Unit',
            'code' => 'CICO-CU',
            'parent_id' => $officeDept1->id, // Child of Information Commission
        ]);

        $officeDept2->setTranslation('name', 'bn', 'কন্ট্রোল ইউনিট');
    }
}