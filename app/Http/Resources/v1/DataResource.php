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
        $data = [
            'service' => config('api-sport.service'),
            'version' => config('api-sport.version'),
            'language' => app()->getLocale(),
            'success' => $this['success'] ?? true,
            'code' => $this['code'] ?? 200,
            'message' => $this['message'] ?? '',
            'support' => config('api-sport.support'),
        ];

        if ($this['success']) {
            if (isset($this['data'])) {
                $data['data'] = $this['data'];
            }
            return $data;
        } else {
            if (isset($this['errors'])) {
                $data['errors'] = $this['errors'];
            }
            return $data;
        }
    }
}
