<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class DataResource extends JsonResource
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
            'service' => config('api-sport.service'),
            'version' => config('api-sport.version'),
            'language' => app()->getLocale(),
            'success' => $this['success'],
            'code' => $this['code'],
            'message' => $this['message'],
            'support' => config('api-sport.support'),
            'data' => $this['data'],
        ];
    }
}
