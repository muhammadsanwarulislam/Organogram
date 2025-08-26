<?php

declare(strict_types=1);

namespace Sanwarul\Organogram\Services\Organization;

use Illuminate\Http\Request;
use Sanwarul\Organogram\Models\Organization;
use Illuminate\Validation\ValidationException;
use Sanwarul\Organogram\Repositories\Organization\OrganizationRepository;

class OrganizationService
{
    public function __construct(protected OrganizationRepository $organizationRepository) {}

    public function getAllOrganizations()
    {
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
        return $organizations;
    }

    public function createOrganization(Request $request)
    {
        $validated = $this->validateOrganizationData($request);

        // Set default level based on parent
        if (!empty($validated['parent_id'])) {
            $parent = $this->organizationRepository->find($validated['parent_id']);
            $validated['level'] = $parent ? $parent->level + 1 : 1;
        } else {
            $validated['level'] = 1;
        }

        return $this->organizationRepository->create($validated);
    }

    public function getOrganizationById(int $id)
    {
        return $this->organizationRepository->find($id, ['parent', 'children', 'departments.positions.employee', 'employees']);
    }

    public function updateOrganization(Request $request, int $id)
    {
        $organization = $this->organizationRepository->find($id);
        $validated = $this->validateOrganizationData($request, $id);

        // Update level if parent changed
        if (isset($validated['parent_id']) && $validated['parent_id'] != $organization->parent_id) {
            if (!empty($validated['parent_id'])) {
                $parent = $this->organizationRepository->find($validated['parent_id']);
                $validated['level'] = $parent ? $parent->level + 1 : 1;
            } else {
                $validated['level'] = 1;
            }
        }

        return $this->organizationRepository->update($id, $validated);
    }

    public function deleteOrganization(int $id)
    {
        $organization = $this->organizationRepository->find($id);

        // Check if organization has children
        if ($organization->children()->exists()) {
            throw ValidationException::withMessages([
                'organization' => 'Cannot delete organization with children. Move or delete children first.'
            ]);
        }

        // Check if organization has departments
        if ($organization->departments()->exists()) {
            throw ValidationException::withMessages([
                'organization' => 'Cannot delete organization with departments. Move or delete departments first.'
            ]);
        }

        // Check if organization has employees
        if ($organization->employees()->exists()) {
            throw ValidationException::withMessages([
                'organization' => 'Cannot delete organization with employees. Move or delete employees first'
            ]);
        }

        return $this->organizationRepository->delete($id);
    }

    public function getOrganizationHierarchy(int $id)
    {
        $organization = $this->organizationRepository->find($id);
        return $this->buildHierarchy($organization);
    }

    protected function buildHierarchy(Organization $organization, int $level = 0): array
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

    protected function validateOrganizationData(Request $request, int $id = null): array
    {
        $rules = [
            'name'      => 'required|string|max:255',
            'code'      => 'required|string|unique:organizations,code',
            'type'      => 'required|string',
            'layer'     => 'nullable|string',
            'origin'    => 'nullable|string',
            'parent_id' => 'nullable|exists:organizations,id',
            'metadata'  => 'nullable|json',
            'status'    => 'sometimes|string|in:active,inactive,dormant',
            'establishment_date' => 'nullable|date',
        ];

        if ($id) {
            $rules['code'] = 'sometimes|required|string|unique:organizations,code,' . $id;
            $rules['name'] = 'sometimes|required|string|max:255';
            $rules['type'] = 'sometimes|required|string';
            $rules['layer'] = 'sometimes|nullable|string';
            $rules['origin'] = 'sometimes|nullable|string';
            $rules['parent_id'] = 'sometimes|nullable|exists:organizations,id';
            $rules['metadata'] = 'sometimes|nullable|json';
            $rules['status'] = 'sometimes|string|in:active,inactive,dormant';
            $rules['establishment_date'] = 'sometimes|nullable|date';
        }

        return $request->validate($rules);
    }
}
