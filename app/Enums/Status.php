<?php

namespace App\Enums;

enum Status: string
{
    case WAITING = "Waiting";
    case IN_CONSULTATION = 'In Consultation';
    case COMPLETED = 'Completed';
}
