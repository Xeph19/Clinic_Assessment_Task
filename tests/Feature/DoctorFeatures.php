<?php

use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

test('doctor can view all active patients with queue details', function () {
    Patient::factory()->createMany([
        [
            'patientName' => 'Normal Patient',
            'urgency' => 'Normal',
            'reason' => 'Follow-up checkup',
            'status' => 'Waiting',
        ],
        [
            'patientName' => 'Urgent Patient',
            'urgency' => 'Urgent',
            'reason' => 'Severe chest pain',
            'status' => 'Waiting',
        ],
        [
            'patientName' => 'Completed Patient',
            'urgency' => 'Urgent',
            'reason' => 'Treatment completed',
            'status' => 'Completed',
        ],
    ]);

    $response = getJson('/api/v1/doctor/all-patients');

    $response
        ->assertOk()
        ->assertJsonCount(2)
        ->assertJsonPath('0.patientName', 'Urgent Patient')
        ->assertJsonPath('1.patientName', 'Normal Patient')
        ->assertJsonStructure([
            '*' => [
                'id',
                'patientName',
                'urgency',
                'reason',
                'status',
                'created_at',
            ],
        ]);
});
