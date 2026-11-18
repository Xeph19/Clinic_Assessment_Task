<?php

use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\patchJson;

uses(RefreshDatabase::class);

test('staff successfully update patient status to in consultation', function () {
    $patient = Patient::factory()->create([
        'patientName' => 'John D Doe',
        'urgency' => 'Normal',
        'reason' => 'Tired and Sick',
        'status' => 'Waiting',
    ]);
    $updateStatus = ['status' => 'In Consultation'];
    $response = patchJson("/api/v1/staff/{$patient->id}/update-status", $updateStatus);

    $response->assertOk();

    assertDatabaseHas('patients', [
        'id' => $patient->id,
        'status' => 'In Consultation',
    ]);
});

test('staff can update a patient from in consultation to completed', function () {
    $patient = Patient::factory()->create([
        'patientName' => 'Juan Dela Cruz',
        'urgency' => 'Normal',
        'reason' => 'Follow-up checkup',
        'status' => 'In Consultation',
    ]);

    $response = patchJson("/api/v1/staff/{$patient->id}/update-status", [
        'status' => 'Completed',
    ]);

    $response->assertOk();

    assertDatabaseHas('patients', [
        'id' => $patient->id,
        'status' => 'Completed',
    ]);
});

test('staff cannot skip from waiting to completed', function () {
    $patient = Patient::factory()->create([
        'patientName' => 'Juan Dela Cruz',
        'urgency' => 'Normal',
        'reason' => 'Follow-up checkup',
        'status' => 'Waiting',
    ]);

    patchJson("/api/v1/staff/{$patient->id}/update-status", [
        'status' => 'Completed',
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'status' => 'Status can only change from Waiting to In Consultation.',
        ]);

    assertDatabaseHas('patients', [
        'id' => $patient->id,
        'status' => 'Waiting',
    ]);
});
