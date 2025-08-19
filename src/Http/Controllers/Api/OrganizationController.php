<?php
declare(strict_types=1);

namespace Sanwarul\Organogram\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sanwarul\Organogram\Models\Organization;
use Sanwarul\Organogram\Traits\JsonResponseTrait;

class OrganizationController extends Controller
{
    use JsonResponseTrait;
    
    public function index()
    {
        try {
            $organizations = Organization::with(['departments.positions.employee', 'employees'])
                ->when(request()->has('type'), function ($query) {
                    $query->where('type', request('type'));
                })
                ->when(request()->has('layer'), function ($query) {
                    $query->where('layer', request('layer'));
                })
                ->when(request()->has('parent_id'), function ($query) {
                    $query->where('parent_id', request('parent_id'));
                })
                ->get();
                
            return $this->successJsonResponse('Organizations retrieved successfully', $organizations);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'      => 'required|string|max:255',
                'code'      => 'required|string|unique:organizations,code',
                'type'      => 'required|string',
                'layer'     => 'nullable|string',
                'origin'    => 'nullable|string',
                'parent_id' => 'nullable|exists:organizations,id',
                'metadata'  => 'nullable|json',
                'status'    => 'sometimes|string|in:active,inactive,dormant',
                'establishment_date' => 'nullable|date',
            ]);
            
            // Set default level based on parent
            if (!empty($validated['parent_id'])) {
                $parent = Organization::find($validated['parent_id']);
                $validated['level'] = $parent ? $parent->level + 1 : 1;
            } else {
                $validated['level'] = 1;
            }
            
            $organization = Organization::create($validated);
            return $this->successJsonResponse('Organization created successfully', $organization->load(['parent', 'children', 'departments', 'employees']));
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function show($id)
    {
        try {
            $organization = Organization::findOrFail($id);
            return $this->successJsonResponse('Organization retrieved successfully',  $organization->load(['parent', 'children', 'departments.positions.employee', 'employees']));
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $organization = Organization::findOrFail($id);
            
            $validated = $request->validate([
                'name'      => 'sometimes|required|string|max:255',
                'code'      => 'sometimes|required|string|unique:organizations,code,'.$organization->id,
                'type'      => 'sometimes|required|string',
                'layer'     => 'sometimes|nullable|string',
                'origin'    => 'sometimes|nullable|string',
                'parent_id' => 'sometimes|nullable|exists:organizations,id',
                'metadata'  => 'sometimes|nullable|json',
                'status'    => 'sometimes|string|in:active,inactive,dormant',
                'establishment_date' => 'sometimes|nullable|date',
            ]);
            
            // Update level if parent changed
            if (isset($validated['parent_id']) && $validated['parent_id'] != $organization->parent_id) {
                if (!empty($validated['parent_id'])) {
                    $parent = Organization::find($validated['parent_id']);
                    $validated['level'] = $parent ? $parent->level + 1 : 1;
                } else {
                    $validated['level'] = 1;
                }
            }
            
            $organization->update($validated);
            return $this->successJsonResponse('Organization updated successfully', $organization->load(['parent', 'children', 'departments', 'employees']));
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try {
            $organization = Organization::findOrFail($id);
            
            // Check if organization has children
            if ($organization->children()->exists()) {
                return $this->errorJsonResponse('Cannot delete organization with children. Move or delete children first.', 422);
            }
            
            // Check if organization has departments
            if ($organization->departments()->exists()) {
                return $this->errorJsonResponse('Cannot delete organization with departments. Move or delete departments first.', 422);
            }
            
            // Check if organization has employees
            if ($organization->employees()->exists()) {
                return $this->errorJsonResponse('Cannot delete organization with employees. Move or delete employees first.', 422);
            }
            
            $organization->delete();
            return $this->successJsonResponse('Organization deleted successfully');
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    public function hierarchy($id)
    {
        try {
            $organization = Organization::findOrFail($id);
            $hierarchy = $this->buildHierarchy($organization);
            
            return $this->successJsonResponse('Organization hierarchy retrieved successfully', $hierarchy);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
    
    protected function buildHierarchy($organization, $level = 0)
    {
        $data = [
            'id' => $organization->id,
            'name' => $organization->name,
            'code' => $organization->code,
            'type' => $organization->type,
            'layer' => $organization->layer,
            'level' => $level,
            'children' => []
        ];
        
        foreach ($organization->children as $child) {
            $data['children'][] = $this->buildHierarchy($child, $level + 1);
        }
        
        return $data;
    }
}