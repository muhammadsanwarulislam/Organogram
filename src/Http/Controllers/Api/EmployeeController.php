<?php
declare(strict_types=1);
namespace Sanwarul\Organogram\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sanwarul\Organogram\Services\Employee\EmployeeService;
use Sanwarul\Organogram\Traits\JsonResponseTrait;

class EmployeeController extends Controller
{
    use JsonResponseTrait;
    
    public function __construct(protected EmployeeService $employeeService) {}
    
    public function index()
    {
        try {
            $employees = $this->employeeService->getAllEmployees();
            return $this->successJsonResponse('Employees retrieved successfully', $employees);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function store(Request $request)
    {
        try {
            $employee = $this->employeeService->createEmployee($request);
            return $this->successJsonResponse('Employee created successfully', $employee);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function show(int $id)
    {
        try {
            $employee = $this->employeeService->getEmployeeById($id);
            return $this->successJsonResponse('Employee retrieved successfully', $employee);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function update(Request $request, int $id)
    {
        try {
            $employee = $this->employeeService->updateEmployee($request, $id);
            return $this->successJsonResponse('Employee updated successfully', $employee);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function destroy(int $id)
    {
        try {
            $this->employeeService->deleteEmployee($id);
            return $this->successJsonResponse('Employee deleted successfully');
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function attachments($id)
    {
        try {
            $attachments = $this->employeeService->getEmployeeAttachments($id);
            return $this->successJsonResponse('Employee attachments retrieved successfully', $attachments);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
}