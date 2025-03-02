<?php

namespace App\Enums;

enum Role: string
{
    case Patient = 'Patient';
    case Caregiver = 'Caregiver';
}
