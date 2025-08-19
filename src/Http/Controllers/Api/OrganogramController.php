<?php
declare(strict_types=1);    

namespace Sanwarul\Organogram\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Sanwarul\Organogram\Models\Organization;
use Sanwarul\Organogram\Traits\JsonResponseTrait;
use Sanwarul\Organogram\Services\OrganogramService;

class OrganogramController extends Controller
{
    use JsonResponseTrait;
    
    protected $organogramService;
    
    public function __construct(OrganogramService $organogramService)
    {
        $this->organogramService = $organogramService;
    }
    
    public function show($id)
    {
        try {
            $organization = Organization::findOrFail($id);
            return $this->successJsonResponse('Organization retrieved successfully', 
                $organization->load(['parent', 'children', 'departments.positions.employee', 'employees'])
            );
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function tree($id)
    {
        try {
            $organization = Organization::findOrFail($id);
            $tree = $this->organogramService->getOrganogramTree($organization);
            
            return $this->successJsonResponse('Organogram tree retrieved successfully', $tree);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function statistics($id)
    {
        try {
            $organization = Organization::findOrFail($id);
            $statistics = $this->organogramService->getOrganizationStatistics($organization);
            
            return $this->successJsonResponse('Organization statistics retrieved successfully', $statistics);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
}