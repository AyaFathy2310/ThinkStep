<?php

namespace App\Enums;

enum CommandType: string
{
    case Move_Forward = 'Move Forward';
    case Move_Backward = 'Move Backward';
    case Turn_Left = 'Turn Left';
    case Turn_Right = 'Turn Right';
    case Stop = 'Stop';
}
