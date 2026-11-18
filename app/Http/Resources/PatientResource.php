<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'patientName'=> $this->patientName,
            'urgency'=>$this->urgency,
            'reason'=>$this->reason,
            'status'=>$this->status,
            'created_at'=>$this->created_at,
        ];
    }
}
