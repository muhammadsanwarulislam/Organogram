<?php
declare(strict_types=1);
namespace Sanwarul\Organogram\Repositories\Department;

use Sanwarul\Organogram\Models\Department;
use Sanwarul\Organogram\Repositories\BaseRepository;

class DepartmentRepository extends BaseRepository
{
    public function __construct(Department $department)
    {
        parent::__construct($department);
    }

    public function findByCode(string $code)
    {
        return $this->model->where('code', $code)->first();
    }
}