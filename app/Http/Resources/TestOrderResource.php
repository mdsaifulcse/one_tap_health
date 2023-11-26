<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestOrderResource extends JsonResource
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
            'order_no'=>$this->order_no,
            'order_status'=>$this->order_status,
            'payment_status'=>$this->payment_status,
            'amount'=>$this->amount,
            'discount'=>$this->discount,
            'service_charge'=>$this->service_charge,
            'total_amount'=>$this->total_amount,
            'test_date'=>$this->test_date,
            'patient_name'=>$this->patient->name,
            'patient_mobile'=>$this->patient->mobile,
            'patient_age'=>$this->patient->age,
            'hospital_name'=>$this->hospital->name,
            'details'=>TestOrderDetailsResourceCollection::make($this->whenLoaded('testOrderDetails')),
        ];
    }
}
