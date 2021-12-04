<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workout extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prevable_type', 'prevable_id', 'day', 'reps_based', 'reps', 'time_based', 'time', 'set_number', 'rest_time'
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
        'id', 'deleted_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'exercise_id' => 'integer',
        'program_id' => 'integer',
        'set_id' => 'integer',
        'day' => 'integer',
        'reps' => 'integer',
        'time' => 'integer',
        'set_number' => 'integer',
        'rest_time' => 'integer',
        'prevable_id' => 'integer',
        'prevable_type' => 'string',
        'reps_based' => 'boolean',
        'time_based' => 'boolean',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function set()
    {
        return $this->belongsTo(Set::class);
    }
}
