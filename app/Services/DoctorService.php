<?php

namespace App\Services;

use App\Models\Patient;

class DoctorService
{
    /**
     * Get all patients in Queueu and sorted by urgency and date
     * @return void
     */
    public function getAllPatientQueueu()
    {
        $patients = Patient::query()
                           ->where('status', '!=', 'Completed')
                           ->orderByDesc('urgency')
                           ->orderBy('created_at', 'desc')
                           ->get();
        return $patients;
    }
}
