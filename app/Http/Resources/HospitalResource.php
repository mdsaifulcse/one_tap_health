<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HospitalResource extends JsonResource
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
            'name'=>$this->name,
            'branch'=>$this->branch,
            'address1'=>$this->address1,
            'latitude'=>$this->latitude,
            'longitude'=>$this->longitude,
            'photo'=>$this->photo?url($this->photo):'',
            'tests_price'=>HospitalTestPriceResourceCollection::make($this->whenLoaded('hospitalTestPrice')),
        ];
    }
}
