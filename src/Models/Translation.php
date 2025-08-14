<?php
namespace Sanwarul\Organogram\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'table_name',
        'model_id',
        'locale',
        'attribute',
        'value'
    ];
    
    public $timestamps = true;
}