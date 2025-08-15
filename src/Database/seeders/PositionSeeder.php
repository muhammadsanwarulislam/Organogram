<?php
namespace Sanwarul\Organogram\Database\Seeders;

use Sanwarul\Organogram\Models\Department;
use Sanwarul\Organogram\Models\Position;
use Sanwarul\Organogram\Models\Organization;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run()
    {
        // Get departments
        $ministryAdmin = Department::where('code', 'MOPA-ADMIN')->first();
        $ministryFinance = Department::where('code', 'MOPA-FIN')->first();
        $divisionPolicy = Department::where('code', 'PAD-POLICY')->first();
        $divisionImp = Department::where('code', 'PAD-IMP')->first();
        $officeIC = Department::where('code', 'CICO-IC')->first();

        // Create positions for ministry departments
        $obj1 = Position::create([
            'department_id' => $ministryAdmin->id,
            'name' => 'Secretary',
            'code' => 'MOPA-ADMIN-SEC',
            'grade' => 1,
        ]);

        $obj1->setTranslation('name', 'bn', 'সচিব');

        $obj2 = Position::create([
            'department_id' => $ministryAdmin->id,
            'name' => 'Additional Secretary',
            'code' => 'MOPA-ADMIN-ASEC',
            'grade' => 2,
        ]);

        $obj2->setTranslation('name', 'bn', 'অতিরিক্ত সচিব');

        $obj3 = Position::create([
            'department_id' => $ministryFinance->id,
            'name' => 'Joint Secretary',
            'code' => 'MOPA-FIN-JSEC',
            'grade' => 3,
        ]);

        $obj3->setTranslation('name', 'bn', 'যৌথ সচিব');

        $obj4 = Position::create([
            'department_id' => $divisionPolicy->id,
            'name' => 'Senior Assistant Secretary',
            'code' => 'PAD-POLICY-SASEC',
            'grade' => 4,
        ]);

        $obj4->setTranslation('name', 'bn', 'সিনিয়র সহকারী সচিব');

        $obj5 = Position::create([
            'department_id' => $divisionImp->id,
            'name' => 'Assistant Secretary',
            'code' => 'PAD-IMP-ASEC',
            'grade' => 5,
        ]);

        $obj5->setTranslation('name', 'bn', 'সহকারী সচিব');

        $obj6 = Position::create([
            'department_id' => $officeIC->id,
            'name' => 'Chief Information Commissioner',
            'code' => 'CICO-IC-CIC',
            'grade' => 1,
        ]);
        $obj6->setTranslation('name', 'bn', 'প্রধান তথ্য কমিশনার');
    }
}