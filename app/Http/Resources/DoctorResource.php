<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'mobile'=>$this->mobile,
            'email'=>$this->email,
            'degree'=>$this->degree,
            'department'=>$this->department,
            'bio'=>$this->bio,
            'photo'=>$this->photo?url($this->photo):'',
            'schedule'=>DoctorHospitalWiseScheduleResourceCollection::make($this->whenLoaded('doctorSchedules')),
        ];
    }
}
