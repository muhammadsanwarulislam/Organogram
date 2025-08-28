<?php
namespace Sanwarul\Organogram\Database\Seeders;

use Sanwarul\Organogram\Models\Employee;
use Sanwarul\Organogram\Models\Organization;
use Sanwarul\Organogram\Models\Position;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        // Get organizations and positions
        $ministry = Organization::where('code', 'MOPA')->first();
        $division = Organization::where('code', 'PAD')->first();
        $office = Organization::where('code', 'CICO')->first();
        $lawMinistry = Organization::where('code', 'LAW')->first();
        $nhrc = Organization::where('code', 'NHRC')->first();

        $ministrySec = Position::where('code', 'MOPA-ADMIN-SEC')->first();
        $ministryAsec = Position::where('code', 'MOPA-ADMIN-ASEC')->first();
        $divisionSasec = Position::where('code', 'PAD-POLICY-SASEC')->first();
        $divisionAsec = Position::where('code', 'PAD-IMP-ASEC')->first();
        $officeCic = Position::where('code', 'CICO-IC-CIC')->first();

        // Create employees
        $sec = Employee::create([
            'position_id' => $ministrySec->id,
            'organization_id' => $ministry->id,
            'name' => 'Md. Abdul Karim',
            'employee_id' => 'MOPA-001',
            'email' => 'sec@mopa.gov.bd',
            'phone' => '01711111111',
            'joining_date' => '2020-01-01',
        ]);
        $sec->setTranslation('name', 'bn', 'মোহাম্মদ আব্দুল করিম');
        $sec->setTranslation('phone', 'bn', '০১৭১১১১১১১১১');

        $asec = Employee::create([
            'position_id' => $ministryAsec->id,
            'organization_id' => $ministry->id,
            'name' => 'Fatema Begum',
            'employee_id' => 'MOPA-002',
            'email' => 'asec@mopa.gov.bd',
            'phone' => '01722222222',
            'joining_date' => '2021-02-15',
            'reporting_to' => $sec->id,
        ]);
        $asec->setTranslation('name', 'bn', 'ফাতেমা বেগম');
        $asec->setTranslation('phone', 'bn', '০১৭২২২২২২২২');

        $sasec = Employee::create([
            'position_id' => $divisionSasec->id,
            'organization_id' => $division->id,
            'name' => 'Rahim Uddin',
            'employee_id' => 'PAD-001',
            'email' => 'sasec@pad.gov.bd',
            'phone' => '01744444444',
            'joining_date' => '2021-05-10',
        ]);
        $sasec->setTranslation('name', 'bn', 'রহিম উদ্দিন');
        $sasec->setTranslation('phone', 'bn', '০১৭৪৪৪৪৪৪৪৪');

        $asec2 = Employee::create([
            'position_id' => $divisionAsec->id,
            'organization_id' => $division->id,
            'name' => 'Salma Akter',
            'employee_id' => 'PAD-002',
            'email' => 'asec@pad.gov.bd',
            'phone' => '01755555555',
            'joining_date' => '2022-07-01',
            'reporting_to' => $sasec->id,
        ]);
        $asec2->setTranslation('name', 'bn', 'সালমা আক্তার');
        $asec2->setTranslation('phone', 'bn', '০১৭৫৫৫৫৫৫৫৫');

        $cic = Employee::create([
            'position_id' => $officeCic->id,
            'organization_id' => $office->id,
            'name' => 'Dr. Kamal Uddin',
            'employee_id' => 'CICO-001',
            'email' => 'cic@cico.gov.bd',
            'phone' => '01766666666',
            'joining_date' => '2019-09-15',
        ]);
        $cic->setTranslation('name', 'bn', 'ড. কামাল উদ্দিন');

        $this->createSampleAttachments([$sec, $asec, $sasec, $asec2, $cic]);
    }

    private function createSampleAttachments($employees)
    {
        foreach ($employees as $employee) {
            // Create a photo attachment record
            $employee->attachments()->create([
                'name' => 'photo',
                'file_name' => $employee->employee_id . '.jpg',
                'mime_type' => 'image/jpeg',
                'extension' => 'jpg',
                'size' => 62000, 
                'path' => 'attachments/employees/' . $employee->employee_id . '.jpg',
                'disk' => 'public',
                'hash' => md5($employee->employee_id . 'photo'),
                'metadata' => json_encode([
                    'type' => 'photo',
                    'width' => 300,
                    'height' => 300,
                    'alt' => $employee->name . ' photo'
                ])
            ]);

            // Create a document attachment record
            $employee->attachments()->create([
                'name' => 'cv',
                'file_name' => $employee->employee_id . '_cv.pdf',
                'mime_type' => 'application/pdf',
                'extension' => 'pdf',
                'size' => 256000, // 256KB
                'path' => 'attachments/employees/' . $employee->employee_id . '_cv.pdf',
                'disk' => 'public',
                'hash' => md5($employee->employee_id . 'cv'),
                'metadata' => json_encode([
                    'type' => 'cv',
                    'pages' => 2,
                    'title' => $employee->name . ' CV'
                ])
            ]);
        }
    }
}