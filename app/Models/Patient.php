<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Priority;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory;
    protected $fillable = [
        'patientName',
        'urgency',
        'reason',
        'status',
    ];
    public function casts(): array
    {
        return [
            'urgency'=> Priority::class,
            'status'=> Status::class,
        ];
    }
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
