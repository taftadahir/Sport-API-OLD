<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'days', 'use_warm_up', 'use_program_set', 'use_workout_set', 'published', 'image'
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
        'name' => 'string',
        'image' => 'string',
        'days' => 'integer',
        'use_warm_up' => 'boolean',
        'use_program_set' => 'boolean',
        'use_workout_set' => 'boolean',
        'published' => 'boolean',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
