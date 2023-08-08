<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HospitalTestPriceResource extends JsonResource
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
            'test_id'=>$this->id,
            //'hospital_id'=>$this->pivot->hospital_id,
            'test_title'=>$this->title,
            'test_sub_title'=>$this->sub_title,
            'price'=>$this->pivot->price,
            'discount'=>$this->pivot->discount,
            'description'=>$this->description,
            //'test_category'=>$this->test_category?$this->test_category->category_name:'',
            'icon_photo'=>$this->icon_photo?url($this->icon_photo):'',
        ];
    }
}
