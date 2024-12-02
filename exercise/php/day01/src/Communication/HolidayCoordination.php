<?php

declare(strict_types=1);

namespace Communication;

use DateTime;

final class HolidayCoordination 
{
    private const CHRISTMAS_MONTH = 12;
    private const CHRISTMAS_DAY = 25;

    public function __construct(private int $daysToRest = 0, private int $daysForComingBack = 0){}

    public function isOverdue(): bool
    {
        return $this->daysBeforeReturn() <= 0 ? true : false;
    }

    public  function daysBeforeReturn(int $daysToRest = 0, int $daysForComingBack = 0):int
    {
        return $this->daysBeforeChristmas() - $this->daysToRest - $this->daysForComingBack;
    }

    public function daysBeforeChristmas(): int
    {
        $currentDate = new DateTime();

        $christmasDay = new DateTime();
        $christmasDay->setDate((int) $currentDate->format('Y'), self::CHRISTMAS_MONTH, self::CHRISTMAS_DAY);
        $difference = $currentDate->diff($christmasDay);

        return max(0, (int) $difference->days);
    }
}
