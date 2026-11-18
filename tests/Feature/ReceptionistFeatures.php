<?php

use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);
/**
 * A several pest testing for validation of request methods and
 * routes
 */
test('receptionist successfully created patient', function () {
    // Arrange
    $payload = [
        'patientName' => 'John D Doe',
        'urgency' => 'Normal',
        'reason' => 'Tired and Sick',
        'status' => 'Completed',
    ];
    // Act
    $response = postJson('/api/v1/receptionist/add-patient', $payload);

    $response->assertOk();
    // Assert
    assertDatabaseHas('patients', [
        'patientName' => 'John D Doe',
        'urgency' => 'Normal',
        'status' => 'Waiting',
    ]);
});

test('the system stops submission when urgency is invalid', function () {
    $response = postJson('/api/v1/receptionist/add-patient', [
        'patientName' => 'Juan Dela Cruz',
        'urgency' => 'High',
        'reason' => 'Follow-up checkup',
    ]);

    $response
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['urgency']);
});

test('the system stops submission when the patient name is only spaces', function () {
    $response = postJson('/api/v1/receptionist/add-patient', [
        'patientName' => '   ',
        'urgency' => 'Normal',
        'reason' => 'Follow-up checkup',
    ]);

    $response
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'patientName' => 'Patient name is required.',
        ]);
});

test('the system stop submit when the form has an empty patient name', function () {
    $payload = [
        'patientName' => '',
        'urgency' => 'Normal',
        'reason' => 'Tired and Sick',
        'status' => 'Waiting',
    ];
    $response = postJson('/api/v1/receptionist/add-patient', $payload);
    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['patientName' => 'Patient name is required.']);
});
test('receptionist successfully remove the patient on the list', function () {
    $patient = Patient::factory()->create([
        'patientName' => 'John D Doe',
        'urgency' => 'Normal',
        'reason' => 'Tired and Sick',
        'status' => 'Waiting',
    ]);
    $response = deleteJson("/api/v1/receptionist/{$patient->id}/delete-profile");
    $response->assertOk();

    assertDatabaseMissing('patients', [
        'id' => $patient->id,
    ]);
});
