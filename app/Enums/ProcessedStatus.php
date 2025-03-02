<?php

namespace App\Enums;

enum ProcessedStatus: string
{
    case Pending = 'Pending';
    case Processed = 'Processed';
}
