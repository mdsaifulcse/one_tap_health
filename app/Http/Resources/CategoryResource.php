<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id'=>$this->id,
            'name'=>$this->category_name,
            'description'=>$this->short_description,
            'sequence'=>$this->sequence,
            'icon_photo'=>$this->icon_photo?url($this->icon_photo):'',
        ];
    }
}
