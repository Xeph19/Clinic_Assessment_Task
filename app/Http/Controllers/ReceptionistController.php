<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Services\ReceptionistService;
use App\Models\Receptionist;
use App\Models\Patient;
use App\Http\Requests\StoreReceptionistRequest;
use App\Http\Requests\UpdateReceptionistRequest;
use App\Http\Resources\PatientResource;
class ReceptionistController extends Controller
{
    public function __construct(protected ReceptionistService $service)
    {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        //Validated Request
        $validatedPatient = $request->validated();
        //Inject the data to the service logic
        $isPatientAddedOnQueue = $this->service->addPatientOnQueue($validatedPatient);
        //Return status and patient resource
        return response()->json([
            'message'=>'Successfully Add the Patient to the Queue',
            'data' => new PatientResource($isPatientAddedOnQueue)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Receptionist $receptionist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Receptionist $receptionist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReceptionistRequest $request, Receptionist $receptionist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $this->service->removePatientFromList($patient);
    }
}
