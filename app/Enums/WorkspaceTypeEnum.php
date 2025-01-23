<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum WorkspaceTypeEnum: string
{
    use EnumTrait;

    case INDIVIDUAL = 'individual';
    case INSTITUTION = 'institution';

    public function label(): string
    {
        return match ($this) {
            WorkspaceTypeEnum::INDIVIDUAL => 'Individual',
            WorkspaceTypeEnum::INSTITUTION => 'Institution',
        };
    }
}
