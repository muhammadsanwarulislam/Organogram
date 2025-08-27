<?php

namespace Sanwarul\Organogram\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'joining_date'  => $this->joining_date,
            'organization'  => $this->organization,
            'position'      => $this->position,
            'reportsTo'     => $this->reportsTo,
            'subordinate'   => $this->subordinates,
            'translations'  => $this->translations,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at
        ];
    }
}
