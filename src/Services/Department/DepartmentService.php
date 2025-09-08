<?php
declare(strict_types=1);

namespace Sanwarul\Organogram\Services\Department;

use Sanwarul\Organogram\Repositories\Department\DepartmentRepository;
use Illuminate\Http\Request;

class DepartmentService
{
    public function __construct(protected DepartmentRepository $departmentRepository) {}

    public function getAllDepartments()
    {
        return $this->departmentRepository->all(['organization', 'parent', 'children', 'positions.employee', 'translations']);
    }

    public function createDepartment(Request $request)
    {
        $validated = $this->validateDepartmentData($request);
        
        $departmentData =[
            'organization_id'   => $validated['organization_id'],
            'parent_id'         => $validated['parent_id'] ?? null,
            'name'              => $validated['name']['en'],
            'code'              => $validated['code']['en'],
        ];

        $department = $this->departmentRepository->create($departmentData);

        $this->departmentRepository->setLocalization($department, $validated);
        
        return $department;
    }

    public function getDepartmentById(int $id)
    {
        $localization = $this->departmentRepository->getLocalization($this->departmentRepository->find($id));
        return $this->departmentRepository->find($id, ['organization', 'parent', 'children', 'positions.employee']);
    }

    public function updateDepartment(Request $request, int $id)
    {
        $validated = $this->validateDepartmentData($request, $id);

        return $this->departmentRepository->update($id, $validated);
    }

    public function deleteDepartment(int $id)
    {
        return $this->departmentRepository->delete($id);
    }

    protected function validateDepartmentData(Request $request, int $id = null): array
    {
        $rules = [
            'organization_id'   => 'required|exists:organizations,id',
            'name.en'           => 'required|string|max:255',
            'name.bn'           => 'nullable|string|max:255',
            'code.en'           => 'required|string|max:255|unique:departments,code',
            'code.bn'           => 'nullable|string|max:255',
            'parent_id'         => 'nullable|exists:departments,id',
            'description'       => 'nullable|string',
        ];
        
        if ($id) {
            $rules['code.en'] = 'required|string|max:255|unique:departments,code,' . $id;
        }
        
        return $request->validate($rules);
    }
}
