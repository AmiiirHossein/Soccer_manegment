<?php

namespace App\Enums;

enum UserRole : string
{
    case PLAYER = 'player';
    case ORGANIZER = 'organizer';
    case ADMIN = 'admin';
    case COACH = 'coach';
}
