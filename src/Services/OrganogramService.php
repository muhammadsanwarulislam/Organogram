<?php
declare(strict_types=1);

namespace Sanwarul\Organogram\Services;

use Sanwarul\Organogram\Models\Organization;

class OrganogramService
{
    public function getOrganogramTree(Organization $organization)
    {
        // Build hierarchical structure
        $tree = [
            'id' => $organization->id,
            'name' => $organization->name,
            'type' => $organization->type,
            'children' => []
        ];

        // Get top-level departments (no parent)
        $departments = $organization->departments()
            ->whereNull('parent_id')
            ->with(['positions.employee', 'children.positions.employee'])
            ->get();

        foreach ($departments as $department) {
            $tree['children'][] = $this->buildDepartmentNode($department);
        }

        return $tree;
    }

    public function getOrganizationStatistics(Organization $organization)
    {
        $statistics = [
            'total_departments' => $organization->departments()->count(),
            'total_employees' => $organization->employees()->count(),
        ];

        return $statistics;
    }
    private function buildDepartmentNode($department)
    {
        $node = [
            'id' => $department->id,
            'name' => $department->name,
            'type' => 'department',
            'children' => []
        ];

        // Add positions
        foreach ($department->positions as $position) {
            $node['children'][] = [
                'id' => $position->id,
                'name' => $position->name,
                'type' => 'position',
                'employee' => $position->employee ? [
                    'id' => $position->employee->id,
                    'name' => $position->employee->name,
                    'employee_id' => $position->employee->employee_id,
                ] : null
            ];
        }

        // Add child departments recursively
        foreach ($department->children as $childDepartment) {
            $node['children'][] = $this->buildDepartmentNode($childDepartment);
        }

        return $node;
    }
}