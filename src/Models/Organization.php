<?php

namespace Sanwarul\Organogram\Models;

use Illuminate\Database\Eloquent\Model;
use Sanwarul\Organogram\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'name',
        'code',
        'type',
        'parent_id',
        'address',
        'phone',
        'email',
        'website',
        'logo'
    ];

    protected $translatable = ['name','address'];


    public function parent()
    {
        return $this->belongsTo(Organization::class, 'parent_id');

    }

    public function children()
    {
        return $this->hasMany(Organization::class, 'parent_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'organization_id');
    }
}