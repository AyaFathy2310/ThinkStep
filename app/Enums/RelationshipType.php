<?php

namespace App\Enums;

enum RelationshipType: string
{
    case Family = 'Family';
    case Friend = 'Friend';
    case Doctor = 'Doctor';
}
