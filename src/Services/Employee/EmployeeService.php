<?php
declare(strict_types=1);
namespace Sanwarul\Organogram\Services\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Sanwarul\Organogram\Repositories\Employee\EmployeeRepository;
use Sanwarul\Organogram\Models\Employee;

class EmployeeService
{
    public function __construct(protected EmployeeRepository $employeeRepository) {}
    
    public function getAllEmployees()
    {
        $employees = Employee::with(['position', 'organization', 'reportsTo', 'subordinates', 'attachments'])
                ->when(request()->has('organization_id'), function ($query) {
                    $query->where('organization_id', request('organization_id'));
                })
                ->when(request()->has('position_id'), function ($query) {
                    $query->where('position_id', request('position_id'));
                })
                ->get();
        
        return $employees;
    }
    
    public function createEmployee(Request $request)
    {
        $validated = $this->validateEmployeeData($request);
        $employee = $this->employeeRepository->create($validated);
        
        // Handle file uploads
        $this->handleFileUploads($employee, $request);
        
        return $employee->load(['position', 'organization', 'reportsTo', 'subordinates', 'attachments']);
    }
    
    public function getEmployeeById(int $id)
    {
        return $this->employeeRepository->find($id, ['position', 'organization', 'reportsTo', 'subordinates', 'attachments']);
    }
    
    public function updateEmployee(Request $request, int $id)
    {
        $employee = $this->employeeRepository->find($id);
        $validated = $this->validateEmployeeData($request, $id);
        
        $employee = $this->employeeRepository->update($id, $validated);
        
        // Handle file uploads
        $this->handleFileUploads($employee, $request, true);
        
        return $employee->load(['position', 'organization', 'reportsTo', 'subordinates', 'attachments']);
    }
    
    public function deleteEmployee(int $id)
    {
        $employee = $this->employeeRepository->find($id);
        
        // Delete all attachments
        $employee->attachments()->delete();
        
        return $this->employeeRepository->delete($id);
    }
    
    public function getEmployeeAttachments(int $id)
    {
        $employee = $this->employeeRepository->find($id);
        return $employee->attachments()->get();
    }
    
    protected function validateEmployeeData(Request $request, int $id = null): array
    {
        $rules = [
            'position_id'    => 'required|exists:positions,id',
            'organization_id'=> 'required|exists:organizations,id',
            'name'           => 'required|string|max:255',
            'employee_id'    => 'required|string|unique:employees,employee_id',
            'email'          => 'required|email|unique:employees,email',
            'phone'          => 'required|string',
            'joining_date'   => 'required|date',
            'reporting_to'   => 'nullable|exists:employees,id',
        ];
        
        if ($id) {
            $rules['position_id']     = 'sometimes|required|exists:positions,id';
            $rules['organization_id'] = 'sometimes|required|exists:organizations,id';
            $rules['name']            = 'sometimes|required|string|max:255';
            $rules['employee_id']     = 'sometimes|required|string|unique:employees,employee_id,'.$id;
            $rules['email']           = 'sometimes|required|email|unique:employees,email,'.$id;
            $rules['phone']           = 'sometimes|required|string';
            $rules['joining_date']    = 'sometimes|required|date';
            $rules['reporting_to']    = 'sometimes|required|exists:employees,id';
        }
        
        return $request->validate($rules);
    }
    
    protected function handleFileUploads(Employee $employee, Request $request, bool $isUpdate = false): void
    {
        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($isUpdate && $employee->photo) {
                $employee->photo->delete();
            }
            $employee->addPhoto($request->file('photo'));
        }
        
        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $employee->addAttachment($file, 'document');
            }
        }
    }
}