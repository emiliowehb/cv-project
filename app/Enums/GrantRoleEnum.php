<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum GrantRoleEnum: string
{
    use EnumTrait;

    case PI = 'PI';
    case COI = 'Co-I';

    public function label(): string
    {
        return match ($this) {
            GrantRoleEnum::PI => 'PI',
            GrantRoleEnum::COI => 'Co-I',
        };
    }
}
