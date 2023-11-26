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
            'hospital_name'=>$this->hospital->name,
            'hospital_branch'=>$this->hospital->branch,
            'hospital_address'=>$this->hospital->address1,
            'doctor_name'=>$this->doctor->name,
            'doctor_degree'=>$this->doctor->degree,
            'doctor_department'=>$this->doctor->department,
            'doctor_bio'=>$this->doctor->bio,
            'doctor_fee'=>$this->doctor_fee,
            'discount'=>$this->discount,
            'fee_after_discount'=>$this->fee_after_discount,
            'doctorAvailableDay'=>$this->doctorAvailableDay,
            'start_time'=>date('h:i:s a', strtotime($this->available_from)),
            'end_time'=>date('h:i:s a', strtotime($this->available_to)),
            'active'=>$this->status==1?true:false,
        ];
    }
}
