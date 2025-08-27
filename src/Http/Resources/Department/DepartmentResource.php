<?php

namespace Sanwarul\Organogram\Http\Resources\Department;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'code'          => $this->code,
            'parent'        => $this->parent,
            'children'      => $this->children,
            'organization'  => $this->organization,
            'positions'     => $this->positions,
            'translations'  => $this->translations,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at
        ];
    }
}
