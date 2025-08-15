<?php
declare(strict_types=1);    

namespace Sanwarul\Organogram\Controllers\Http\Api;

use App\Http\Controllers\Controller;
use Sanwarul\Organogram\Models\Department;
use Illuminate\Http\Request;
use Sanwarul\Organogram\Traits\JsonResponseTrait;

class DepartmentController extends Controller
{
    use JsonResponseTrait;

    public function index()
    {
        try {
            $departments = Department::with(['organization', 'parent', 'children', 'positions.employee'])->get();
            return $this->successJsonResponse('Departments retrieved successfully', $departments);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'organization_id' => 'required|exists:organizations,id',
                'name' => 'required|string|max:255',
                'code' => 'required|string|unique:departments,code',
                'parent_id' => 'nullable|exists:departments,id',
            ]);

            $department = Department::create($request->all());
            return $this->successJsonResponse('Department created successfully', $department);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function show($id): mixed
    {
        try {
            $department = Department::findOrFail($id);
            return $this->successJsonResponse('Department retrieved successfully', $department->load(['organization', 'parent', 'children', 'positions.employee']));
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id): mixed
    {
        try {
            $department = Department::findOrFail($id);
            
            $request->validate([
                'organization_id' => 'required|exists:organizations,id',
                'name' => 'required|string|max:255',
                'code' => 'required|string|unique:departments,code,'.$id,
                'parent_id' => 'nullable|exists:departments,id',
            ]);

            $department->update($request->all());
            return $this->successJsonResponse('Department updated successfully', $department);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $department = Department::findOrFail($id);
            $department->delete();
            return $this->successJsonResponse('Department deleted successfully');
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
}