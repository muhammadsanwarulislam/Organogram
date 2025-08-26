<?php
declare(strict_types=1);
namespace Sanwarul\Organogram\Repositories\Employee;

use Sanwarul\Organogram\Models\Employee;
use Sanwarul\Organogram\Repositories\BaseRepository;

class EmployeeRepository extends BaseRepository
{
    public function __construct(Employee $employee)
    {
        parent::__construct($employee);
    }

    public function findByEmployeeId(string $employeeId)
    {
        return $this->model->where('employee_id', $employeeId)->first();
    }
    
    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }
}