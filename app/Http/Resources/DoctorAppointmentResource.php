<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorAppointmentResource extends JsonResource
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
            'appointment_no'=>$this->appointment_no,
            'appointment_status'=>$this->appointment_status,
            'amount'=>$this->amount,
            'discount'=>$this->discount,
            'service_charge'=>$this->service_charge,
            'total_amount'=>$this->total_amount,
            'appointment_date'=>$this->appointment_date,
            'patient_name'=>$this->patient->name,
            'details'=>DoctorAppointmentDetailsResourceCollection::make($this->whenLoaded('doctorAppointmentDetails')),
        ];
    }
}
