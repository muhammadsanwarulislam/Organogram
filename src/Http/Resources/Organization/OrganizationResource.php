<?php

namespace Sanwarul\Organogram\Http\Resources\Organization;

use Illuminate\Http\Resources\Json\JsonResource;
use Sanwarul\Organogram\Http\Resources\Employee\EmployeeResource;
use Sanwarul\Organogram\Http\Resources\Department\DepartmentResource;

class OrganizationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'code'              => $this->code,
            'type'              => $this->type,
            'layer'             => $this->layer,
            'origin'            => $this->origin,
            'level'             => $this->level,
            'metadata'          => $this->metadata,
            'departments'       => DepartmentResource::collection($this->departments),
            'employees'         => EmployeeResource::collection($this->employees),
            'status'            => $this->status,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at
        ];
    }
}
