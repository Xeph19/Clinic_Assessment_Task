<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Receptionist extends Model
{
    /** @use HasFactory<\Database\Factories\ReceptionistFactory> */
    use HasFactory;

    protected $fillable = [
    ];

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class);
    }

}
