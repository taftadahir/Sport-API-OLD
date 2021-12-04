<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class SetResource extends JsonResource
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
            'name' => $this->name,
            'day' => $this->day,
            'set' => $this->set,
            'rest_time' => $this->rest_time,
            'warm_up_set' => $this->warm_up_set,
        ];
    }
}
