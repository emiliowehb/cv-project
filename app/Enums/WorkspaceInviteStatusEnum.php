<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum WorkspaceInviteStatusEnum: string
{
    use EnumTrait;

    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case REGISTERED = 'registered';

    public function label(): string
    {
        return match ($this) {
            WorkspaceInviteStatusEnum::PENDING => 'Pending',
            WorkspaceInviteStatusEnum::IN_PROGRESS => 'In Progress',
            WorkspaceInviteStatusEnum::REGISTERED => 'Registered',
        };
    }
}
