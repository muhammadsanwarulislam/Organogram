<?php

namespace Sanwarul\Organogram\Models;

use Illuminate\Database\Eloquent\Model;
use Sanwarul\Organogram\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'position_id',
        'organization_id',
        'name',
        'employee_id',
        'email',
        'phone',
        'photo',
        'joining_date',
        'reporting_to'
    ];

    protected $translatable = ['name'];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function reportsTo()
    {
        return $this->belongsTo(Employee::class, 'reporting_to');
    }

    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'reporting_to');
    }
}
