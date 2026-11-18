<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Staff;
use App\Services\StaffService;
use Illuminate\Http\Request;
use App\Models\Patient;

class StaffController extends Controller
{
    public function __construct(protected StaffService $service){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $validatedStatus = $request->validated();
        $patient = $this->service->updatePatientProfile($patient, $validatedStatus['status']);
        return response()->json([
            'message'=>'Successfully Updated Patient Status',
            'patient'=> new PatientResource($patient),
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $this->service->removePatientFromList($patient);
    }
}
