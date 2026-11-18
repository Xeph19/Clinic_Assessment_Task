<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\Patient;
use App\Models\Receptionist;
use Illuminate\Support\Facades\DB;
class ReceptionistService
{
    public function addPatientOnQueue(array $data)
    {
        return Patient::query()
                        ->with('patient')
                        ->create([
                            'patientName'=>$data['patientName'] ,
                            'urgency'=>$data['urgency'],
                            'reason'=>$data['reason'],
                            'status'=>Status::WAITING->value,
                        ]);
    }
    public function removePatientFromList(Patient $patient)
    {
        return DB::transaction(function () use ($patient){
            $patient = $patient->delete();
            return $patient;
        });
    }
}
