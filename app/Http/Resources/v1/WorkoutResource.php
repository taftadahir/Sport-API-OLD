<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'program_id' => $this->program_id,
            'exercise_id' => $this->exercise_id,
            'exercise' => new ExerciseResource($this->exercise),
            'set_id' => $this->set_id,
            'day' => $this->day,
            'reps_based' => $this->reps_based,
            'reps' => $this->reps,
            'time_based' => $this->time_based,
            'time' => $this->time,
            'set_number' => $this->set_number,
            'rest_time' => $this->rest_time,
        ];
    }
}
