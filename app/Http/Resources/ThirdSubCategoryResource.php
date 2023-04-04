<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ThirdSubCategoryResource extends JsonResource
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
            'sub_category_id'=>$this->sub_category_id,
            'sub_category_name'=>$this->subCategory->sub_category_name ,
            'name'=>$this->third_sub_category,
            'description'=>$this->description,
            'status'=>$this->status,
            'sequence'=>$this->sequence,
            'icon_photo'=>$this->icon_photo?url($this->icon_photo):'',
        ];
    }
}
