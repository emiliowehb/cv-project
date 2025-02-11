<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum MonthEnum: string
{
    use EnumTrait;


    case JANUARY = 'january';
    case FEBRUARY = 'february';
    case MARCH = 'march';
    case APRIL = 'april';
    case MAY = 'may';
    case JUNE = 'june';
    case JULY = 'july';
    case AUGUST = 'august';
    case SEPTEMBER = 'september';
    case OCTOBER = 'october';
    case NOVEMBER = 'november';
    case DECEMBER = 'december';

    public function label(): string
    {
        return match ($this) {
            MonthEnum::JANUARY => 'January',
            MonthEnum::FEBRUARY => 'February',
            MonthEnum::MARCH => 'March',
            MonthEnum::APRIL => 'April',
            MonthEnum::MAY => 'May',
            MonthEnum::JUNE => 'June',
            MonthEnum::JULY => 'July',
            MonthEnum::AUGUST => 'August',
            MonthEnum::SEPTEMBER => 'September',
            MonthEnum::OCTOBER => 'October',
            MonthEnum::NOVEMBER => 'November',
            MonthEnum::DECEMBER => 'December',
        };
    }
}
