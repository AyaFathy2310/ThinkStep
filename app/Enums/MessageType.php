<?php

namespace App\Enums;

enum MessageType: string
{
    case Text = 'Text';
    case Voice = 'Voice';
    case FaceCall = 'Video Call';
}
