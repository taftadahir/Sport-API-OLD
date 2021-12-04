<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Set extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prevable_type', 'prevable_id', 'name', 'day', 'number', 'rest_time', 'warm_up_set', 'set_id'
    ];

    /**
     * List of related model which should be cascade softdeleted
     * 
     * @var array
     */
    protected $cascadeDeletes = [
        // 
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        // 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at', 'id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'prevable_type' => 'string',
        'prevable_id' => 'integer',
        'name' => 'string',
        'day' => 'integer',
        'number' => 'integer',
        'rest_time' => 'integer',
        'warm_up_set' => 'boolean',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
