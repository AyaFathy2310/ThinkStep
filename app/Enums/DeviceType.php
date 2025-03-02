<?php

namespace App\Enums;

enum DeviceType: string
{
    case Wheelchair = 'Wheelchair';
    case EEG_Headset = 'EEG Headset';
    case Mobile_App = 'Mobile App';
}
