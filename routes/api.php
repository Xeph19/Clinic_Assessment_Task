<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\StaffController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//v1 prefix of routes
Route::prefix('/v1')->group(function(){
    //Private Routes
    Route::post('/receptionist/add-patient', [ReceptionistController::class, 'store']);
    Route::get('/doctor/all-patients', [DoctorController::class, 'index']);
    Route::patch("/staff/{patient}/update-status", [StaffController::class, 'update']);
    Route::delete("/receptionist/{patient}/delete-profile", [ReceptionistController::class, 'destroy']);
});
