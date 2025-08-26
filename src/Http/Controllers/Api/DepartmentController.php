<?php
declare(strict_types=1);    
namespace Sanwarul\Organogram\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sanwarul\Organogram\Traits\JsonResponseTrait;
use Sanwarul\Organogram\Services\Department\DepartmentService;

class DepartmentController extends Controller
{
    use JsonResponseTrait;

    public function __construct(protected DepartmentService $departmentService){}

    public function index()
    {
        try {
            $departments = $this->departmentService->getAllDepartments();
            return $this->successJsonResponse('Departments retrieved successfully', $departments);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $department = $this->departmentService->createDepartment($request);
            return $this->successJsonResponse('Department created successfully', $department);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function show(int $id): mixed
    {
        try {
            $department = $this->departmentService->getDepartmentById($id);
            return $this->successJsonResponse('Department retrieved successfully', $department);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function update(Request $request, int $id): mixed
    {
        try {
            $department = $this->departmentService->updateDepartment($request, $id);
            return $this->successJsonResponse('Department updated successfully', $department);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->departmentService->deleteDepartment($id);
            return $this->successJsonResponse('Department deleted successfully');
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
}