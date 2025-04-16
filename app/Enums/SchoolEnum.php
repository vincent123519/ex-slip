<?php

namespace App\Enums;

enum SchoolEnum: int
{
    case SCS = 1001;
    case SOE = 1002;
    case SBM = 1003;
    case SAS = 1004;
    case SOED = 1005;
    case SAMS = 1006;
    case SOL = 1007;

    public function label(): string
    {
        return match ($this) {
            self::SCS => 'SCS',
            self::SOE => 'SOE',
            self::SBM => 'SBM',
            self::SAS => 'SAS',
            self::SOED => 'SOED',
            self::SAMS => 'SAMS',
            self::SOL => 'SOL',
        };
    }
}
