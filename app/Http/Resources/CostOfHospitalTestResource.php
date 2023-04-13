<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CostOfHospitalTestResource extends JsonResource
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
            'hospital_id'=>$this->hospital->id,
            'hospital_name'=>$this->hospital->name,
            'hospital_branch'=>$this->hospital->branch,
            'latitude'=>$this->hospital->latitude?$this->hospital->latitude:'',
            'longitude'=>$this->hospital->longitude?$this->hospital->longitude:'',
            'hospital_photo'=>$this->hospital->photo?url($this->hospital->photo):'',
        ];
    }
}
