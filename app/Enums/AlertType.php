<?php

namespace App\Enums;

enum AlertType: string
{
    case BatteryLow = 'Battery Low';
    case Emergency = 'Emergency';
}
