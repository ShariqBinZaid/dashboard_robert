<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PanicSettingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $numbers = [];
        if(!empty($this->phoneNumbers)){
            foreach ($this->phoneNumbers as $number){
                $numbers[] = $number->phone;
            }
        }
        return [
            'message' => $this->message,
            'status' => $this->is_active,
            'numbers' => $numbers
        ];
    }
}
