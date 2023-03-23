<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarDetailsResource extends JsonResource
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
            'id' =>$this->id,
            'model' => $this->model,
            'color' => $this->color,
            'register_no' => $this->register_no,
            'category_type' => $this->category->name,
            'category_id' => $this->category_id,
            'production_year' => $this->making_year,
        ];
    }
}
