<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return[
            'id'=>$this->id,
            'name'=>$this->name,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'address'=>$this->address,
            'user_role'=>$this->user_role,
            'birth_date'=>$this->birth_date?date('Y-m-d',strtotime($this->birth_date)):'',
            'fcm_token'=>$this->fcm_token,
            'profile_photo_url'=>$this->profile_photo_path?url($this->profile_photo_path):null
        ];
        //return parent::toArray($request);
    }
}
