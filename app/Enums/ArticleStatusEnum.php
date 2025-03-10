<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum ArticleStatusEnum: string
{
    use EnumTrait;

    case WAITING_FOR_VALIDATION = 'waiting_for_validation';
    case VALIDATED = 'validated';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            ArticleStatusEnum::WAITING_FOR_VALIDATION => 'Waiting for validation',
            ArticleStatusEnum::VALIDATED => 'Validated',
            ArticleStatusEnum::REJECTED => 'Changes Requested',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            ArticleStatusEnum::WAITING_FOR_VALIDATION => 'badge-warning',
            ArticleStatusEnum::VALIDATED => 'badge-success',
            ArticleStatusEnum::REJECTED => 'badge-danger',
        };
    }

    public function rejectionReason(): string
    {
        return 'Display rejection reason by admin here';
    }
}
