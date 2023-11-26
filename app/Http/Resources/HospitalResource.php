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
            'district_id'=>$this->district_id,
            'district_name'=>$this->district?$this->district->name:'',
            'district_bn_name'=>$this->district?$this->district->bn_name:'',
            'area_id'=>$this->zone_area_id,
            'area_name'=>$this->zoneArea?$this->zoneArea->name:'',
            'area_bn_name'=>$this->zoneArea?$this->zoneArea->bn_name:'',
            'tests_price'=>HospitalTestPriceResourceCollection::make($this->whenLoaded('hospitalTestPrice')),
            'schedule'=>DoctorHospitalWiseScheduleResourceCollection::make($this->whenLoaded('doctorSchedules')),
        ];
    }
}
