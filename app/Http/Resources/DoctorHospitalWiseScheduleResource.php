<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorHospitalWiseScheduleResource extends JsonResource
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
            'hospital'=>$this->hospital->name,
            'start_time'=>date('h:i:s a', strtotime($this->available_from)),
            'end_time'=>date('h:i:s a', strtotime($this->available_to)),
            'active'=>$this->status==1?true:false,
        ];
    }
}
