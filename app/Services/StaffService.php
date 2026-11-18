<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StaffService
{
    public function updatePatientProfile(Patient $patient, string $status): Patient
    {
        $nextStatus = match ($patient->status){
            Status::WAITING=>Status::IN_CONSULTATION,
            Status::IN_CONSULTATION=>Status::COMPLETED,
            Status::COMPLETED=> null,
        };

    if ($nextStatus?->value !== $status) {
        $message = $nextStatus === null
            ? 'Completed patients cannot be updated.'
            : "Status can only change from {$patient->status->value} to {$nextStatus->value}.";

        throw ValidationException::withMessages([
            'status' => $message,
        ]);
    }
    $patient->update([
        'status'=>$status
    ]);

    return $patient->refresh();
    }

}
