<?php

namespace App\Enums;

use MabeEnum\Enum;

class TokenAbilities extends Enum
{
    const CAN_PLAY_GAME = 'game:play';
    const CAN_ADMINISTRATE = 'game:admin';
}
