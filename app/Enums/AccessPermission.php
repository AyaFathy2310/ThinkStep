<?php

namespace App\Enums;

enum AccessPermission: string
{
    case Read = 'Read';
    case Control = 'Control';
}
