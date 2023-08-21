<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestOrderDetailsResource extends JsonResource
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
            'price'=>$this->price,
            'discount'=>$this->discount,
            'price_after_discount'=>$this->price_after_discount,
            'test_name'=>$this->test->title,
            'hospital_name'=>$this->hospital->name,
            'hospital_address'=>$this->hospital->address1,
        ];
    }
}
