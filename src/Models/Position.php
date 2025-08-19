<?php
declare(strict_types=1);

namespace Sanwarul\Organogram\Models;

use Illuminate\Database\Eloquent\Model;
use Sanwarul\Organogram\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'department_id',
        'name',
        'code',
        'grade',
        'responsibilities'
    ];

    protected $translatable = ['name','responsibilities'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}