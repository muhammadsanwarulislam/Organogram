<?php

namespace Sanwarul\Organogram\Http\Resources\Position;

use Illuminate\Http\Resources\Json\JsonResource;
use Sanwarul\Organogram\Http\Resources\Employee\EmployeeResource;
use Sanwarul\Organogram\Http\Resources\Department\DepartmentResource;

class PositionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'code'              => $this->code,
            'grade'             => $this->grade,
            'responsibilities'  => $this->responsibilities,
            'departments'       => new DepartmentResource($this->department),
            'employees'         => new EmployeeResource($this->employee),
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at
        ];
    }
}
