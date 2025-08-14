<?php
declare(strict_types=1);    

namespace Sanwarul\Organogram\Controllers\Http\Api;

use App\Http\Controllers\Controller;
use Sanwarul\Organogram\Models\Organization;
use Sanwarul\Organogram\Traits\JsonResponseTrait;
use Sanwarul\Organogram\Services\OrganogramService;

class OrganogramController extends Controller
{
    use JsonResponseTrait;

    public function __construct(protected OrganogramService $organogramService){}

    public function show($id)
    {
        try {
            $organization = Organization::findOrFail($id);
            return $this->successJsonResponse('Organization retrieved successfully', $organization->load(['parent', 'children', 'departments.positions.employee', 'employees']));
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function tree($id)
    {
        try {
            $organization = Organization::findOrFail($id);
            return $this->successJsonResponse('Organogram tree retrieved successfully', $this->organogramService->getOrganogramTree($organization));
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
}