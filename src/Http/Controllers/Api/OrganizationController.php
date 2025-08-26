<?php
declare(strict_types=1);
namespace Sanwarul\Organogram\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sanwarul\Organogram\Services\Organization\OrganizationService;
use Sanwarul\Organogram\Traits\JsonResponseTrait;

class OrganizationController extends Controller
{
    use JsonResponseTrait;
    
    public function __construct(protected OrganizationService $organizationService) {}
    
    public function index()
    {
        try {
            $organizations = $this->organizationService->getAllOrganizations();
            return $this->successJsonResponse('Organizations retrieved successfully', $organizations);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function store(Request $request)
    {
        try {
            $organization = $this->organizationService->createOrganization($request);
            return $this->successJsonResponse('Organization created successfully', 
                $organization->load(['parent', 'children', 'departments', 'employees']));
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function show(int $id)
    {
        try {
            $organization = $this->organizationService->getOrganizationById($id);
            return $this->successJsonResponse('Organization retrieved successfully', $organization);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function update(Request $request, int $id)
    {
        try {
            $organization = $this->organizationService->updateOrganization($request, $id);
            return $this->successJsonResponse('Organization updated successfully', 
                $organization->load(['parent', 'children', 'departments', 'employees']));
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function destroy(int $id)
    {
        try {
            $this->organizationService->deleteOrganization($id);
            return $this->successJsonResponse('Organization deleted successfully');
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function hierarchy($id)
    {
        try {
            $hierarchy = $this->organizationService->getOrganizationHierarchy($id);
            return $this->successJsonResponse('Organization hierarchy retrieved successfully', $hierarchy);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
}