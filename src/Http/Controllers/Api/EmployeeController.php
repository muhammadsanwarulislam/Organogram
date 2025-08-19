<?php
declare(strict_types=1);
namespace Sanwarul\Organogram\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sanwarul\Organogram\Models\Employee;
use Sanwarul\Organogram\Traits\JsonResponseTrait;

class EmployeeController extends Controller
{
    use JsonResponseTrait;
    
    public function index()
    {
        try {
            $employees = Employee::with(['position', 'organization', 'reportsTo', 'subordinates', 'attachments'])
                ->when(request()->has('organization_id'), function ($query) {
                    $query->where('organization_id', request('organization_id'));
                })
                ->when(request()->has('position_id'), function ($query) {
                    $query->where('position_id', request('position_id'));
                })
                ->get();
                
            return $this->successJsonResponse('Employees retrieved successfully', $employees);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'position_id'    => 'required|exists:positions,id',
                'organization_id'=> 'required|exists:organizations,id',
                'name'           => 'required|string|max:255',
                'employee_id'    => 'required|string|unique:employees,employee_id',
                'email'          => 'required|email|unique:employees,email',
                'phone'          => 'required|string',
                'joining_date'   => 'required|date',
                'reporting_to'   => 'nullable|exists:employees,id',
            ]);

            $employee = Employee::create($validated);
            
            // Handle file uploads if any
            if ($request->hasFile('photo')) {
                $employee->addPhoto($request->file('photo'));
            }
            
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $employee->addAttachment($file, 'document');
                }
            }
            
            return $this->successJsonResponse('Employee created successfully', $employee->load(['position', 'organization', 'reportsTo', 'subordinates', 'attachments']));
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function show($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            return $this->successJsonResponse('Employee retrieved successfully', $employee->load(['position', 'organization', 'reportsTo', 'subordinates', 'attachments']));
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            
            $validated = $request->validate([
                'position_id'     => 'sometimes|required|exists:positions,id',
                'organization_id' => 'sometimes|required|exists:organizations,id',
                'name'            => 'sometimes|required|string|max:255',
                'employee_id'     => 'sometimes|required|string|unique:employees,employee_id,'.$id,
                'email'           => 'sometimes|required|email|unique:employees,email,'.$id,
                'phone'           => 'sometimes|required|string',
                'joining_date'    => 'sometimes|required|date',
                'reporting_to'    => 'sometimes|required|exists:employees,id',
            ]);
            
            $employee->update($validated);
            
            // Handle photo update
            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($employee->photo) {
                    $employee->photo->delete();
                }
                $employee->addPhoto($request->file('photo'));
            }
            
            // Handle new attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $employee->addAttachment($file, 'document');
                }
            }
            
            return $this->successJsonResponse('Employee updated successfully', $employee->load(['position', 'organization', 'reportsTo', 'subordinates', 'attachments']));
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            
            // Delete all attachments
            $employee->attachments()->delete();
            
            $employee->delete();
            return $this->successJsonResponse('Employee deleted successfully');
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function attachments($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $attachments = $employee->attachments()->get();
            
            return $this->successJsonResponse('Employee attachments retrieved successfully', $attachments);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
}