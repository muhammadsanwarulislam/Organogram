<?php
declare(strict_types=1);

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
        'layer',
        'origin',
        'level',
        'metadata',
        'status',
        'parent_id'
    ];

    protected $translatable = ['name','code','type','layer','origin'];

    // Boot method for automatic level calculation
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($organization) {
            if ($organization->parent_id) {
                $parent = static::find($organization->parent_id);
                $organization->level = $parent ? $parent->level + 1 : 1;
            } else {
                $organization->level = 1;
            }
        });

        static::updating(function ($organization) {
            if ($organization->isDirty('parent_id')) {
                $parent = static::find($organization->parent_id);
                $organization->level = $parent ? $parent->level + 1 : 1;
            }
        });
    }

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

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors
    public function getPathAttribute()
    {
        $path = [];
        $current = $this;

        while ($current) {
            array_unshift($path, $current->name);
            $current = $current->parent;
        }

        return implode(' / ', $path);
    }

    // Methods
    public function ancestors()
    {
        $ancestors = collect();
        $parent = $this->parent;

        while ($parent) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }

        return $ancestors;
    }
}
