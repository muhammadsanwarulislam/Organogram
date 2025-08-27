<?php

namespace Sanwarul\Organogram\Http\Resources\Position;

use Illuminate\Http\Resources\Json\JsonResource;

class PositionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'code'          => $this->code,
            'grade'         => $this->grade,
            'responsibilities' => $this->responsibilities,
            'departments'     => $this->department,
            'employees'     => $this->employee,
            'translations'  => $this->translations,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at
        ];
    }
}
