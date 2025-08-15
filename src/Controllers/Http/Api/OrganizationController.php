<?php
declare(strict_types=1);

namespace Sanwarul\Organogram\Controllers\Http\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sanwarul\Organogram\Models\Organization;
use Sanwarul\Organogram\Traits\JsonResponseTrait;

class OrganizationController extends Controller
{
    use JsonResponseTrait;

    public function index()
    {
        try {
            $organizations = Organization::with(['departments.positions.employee', 'employees'])->get();
            return $this->successJsonResponse('Organizations retrieved successfully', $organizations);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'      => 'required|string|max:255',
                'code'      => 'required|string|unique:organizations,code',
                'address'   => 'required|string',
                'phone'     => 'required|string',
                'email'     => 'required|email|unique:organizations,email',
            ]);

            $organization = Organization::create($request->all());
            return $this->successJsonResponse('Organization created successfully', $organization);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $organization = Organization::findOrFail($id);
            return $this->successJsonResponse('Organization retrieved successfully',  $organization->load(['departments.positions.employee', 'employees']));
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function update(Request $request, Organization $id)
    {
        try {
            $organization = Organization::findOrFail($id);
            $request->validate([
                'name'      => 'sometimes|required|string|max:255',
                'code'      => 'sometimes|required|string|unique:organizations,code,'.$organization->id,
                'address'   => 'sometimes|required|string',
                'phone'     => 'sometimes|required|string',
                'email'     => 'sometimes|required|email|unique:organizations,email,'.$organization->id,
            ]);
            $organization->update($request->all());
            return $this->successJsonResponse('Organization updated successfully', $organization);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $organization = Organization::findOrFail($id);
            $organization->delete();
            return $this->successJsonResponse('Organization deleted successfully');
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
}