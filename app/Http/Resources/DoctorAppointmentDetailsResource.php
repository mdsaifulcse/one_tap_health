<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorAppointmentDetailsResource extends JsonResource
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
            'appointment_day'=>$this->appointment_day,
            'time_slot'=>$this->time_slot,
            'doctor_fee'=>$this->doctor_fee,
            'discount'=>$this->discount,
            'fee_after_discount'=>$this->fee_after_discount,
            'doctor_name'=>$this->doctor->name,
            'chamber_no'=>$this->chamber_no,
            'hospital_name'=>$this->hospital->name,
            'hospital_address'=>$this->hospital->address1,
        ];
    }
}
