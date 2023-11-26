<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
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
            'title'=>$this->title,
            'sub_title'=>$this->sub_title,
            'description'=>$this->description,
            'category_name'=>$this->testCategory->category_name,
            'icon_photo'=>$this->icon_photo?url($this->icon_photo):'',
        ];
    }
}
