<?php

namespace App\Enums;

enum CommandStatus: string
{
    case Pending = 'Pending';
    case Executed = 'Executed';
}
