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

    public function setLocalization(Department $department, array $validated)
    {
        if (!empty($validated['name']['bn'])) {
            $department->setTranslation('name', 'bn', $validated['name']['bn']);
        }

        if (!empty($validated['code']['bn'])) {
            $department->setTranslation('code', 'bn', $validated['code']['bn']);
        }
    }

    public function getLocalization(Department $department): array
    {
        return [
            'name' => [
                'en' => $department->name,
                'bn' => $department->translate('name', 'bn'),
            ],
            'code' => [
                'en' => $department->code,
                'bn' => $department->translate('code', 'bn'),
            ],
        ];
    }
}
