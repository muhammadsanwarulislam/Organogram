<?php
declare(strict_types=1);

namespace Sanwarul\Organogram\Models;

use Illuminate\Database\Eloquent\Model;
use Sanwarul\Organogram\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'organization_id',
        'name',
        'code',
        'parent_id',
        'description'
    ];

    protected $translatable = ['name', 'code'];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }
}
