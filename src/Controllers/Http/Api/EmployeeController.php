<?php
declare(strict_types=1);

namespace Sanwarul\Organogram\Controllers\Http\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sanwarul\Organogram\Models\Employee;
use Sanwarul\Organogram\Traits\JsonResponseTrait;

class EmployeeController extends Controller
{
    use JsonResponseTrait;
    
    public function index()
    {
        try {
            $employees = Employee::with(['position', 'organization', 'reportsTo', 'subordinates'])->get();
            return $this->successJsonResponse('Employees retrieved successfully', $employees);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'position_id'    => 'required|exists:positions,id',
                'organization_id'=> 'required|exists:organizations,id',
                'name'           => 'required|string|max:255',
                'employee_id'    => 'required|string|unique:employees,employee_id',
                'email'          => 'required|email|unique:employees,email',
                'phone'          => 'required|string',
                'joining_date'   => 'required|date',
                'reporting_to'   => 'nullable|exists:employees,id',
            ]);

            $employee = Employee::create($request->all());
            return $this->successJsonResponse('Employee created successfully', $employee);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            return $this->successJsonResponse('Employee retrieved successfully', $employee->load(['position', 'organization', 'reportsTo', 'subordinates']));
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $request->validate([
                'position_id'     => 'required|exists:positions,id',
                'organization_id' => 'required|exists:organizations,id',
                'name'            => 'required|string|max:255',
                'employee_id'     => 'required|string|unique:employees,employee_id,'.$id,
                'email'           => 'required|email|unique:employees,email,'.$id,
                'phone'           => 'required|string',
                'joining_date'    => 'required|date',
                'reporting_to'    => 'nullable|exists:employees,id',
            ]);
            $employee->update($request->all());
            return $this->successJsonResponse('Employee updated successfully', $employee);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();
            return $this->successJsonResponse('Employee deleted successfully');
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
}