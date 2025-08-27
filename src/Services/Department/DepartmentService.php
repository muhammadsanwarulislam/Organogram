<?php
declare(strict_types=1);
namespace Sanwarul\Organogram\Services\Department;

use Sanwarul\Organogram\Repositories\Department\DepartmentRepository;
use Illuminate\Http\Request;

class DepartmentService
{
    public function __construct(protected DepartmentRepository $departmentRepository){}

    public function getAllDepartments()
    {
        return $this->departmentRepository->all(['organization', 'parent', 'children', 'positions.employee','translations']);
    }

    public function createDepartment(Request $request)
    {
        $validated = $this->validateDepartmentData($request);

        return $this->departmentRepository->create($validated);
    }

    public function getDepartmentById(int $id)
    {
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
            'name'              => 'required|string|max:255',
            'code'              => 'required|string|unique:departments,code',
            'parent_id'         => 'nullable|exists:departments,id',
        ];

        if ($id) {
            $rules['code'] = 'sometimes|required|string|unique:departments,code,' . $id;
        } else {
            $rules['code'] = 'required|string|unique:departments,code';
        }

        return $request->validate($rules);
    }
}
