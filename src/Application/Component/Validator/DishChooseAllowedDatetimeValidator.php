<?php

declare(strict_types=1);

namespace Meals\Application\Component\Validator;

use Meals\Application\Component\Validator\Exception\OutOfTimeChooseDishException;

class DishChooseAllowedDatetimeValidator
{
    const DAY_OF_WEEK_ALLOWED = 1; // Понедельник
    const HOUR_START = 6;
    const HOUR_END = 22;

    public function validate(\DateTimeInterface $dateTime): void
    {
        $dayNumber = (int) $dateTime->format('N');
        $hour = (int) $dateTime->format('H');

        $dayOfWeekCondition = ($dayNumber === self::DAY_OF_WEEK_ALLOWED);
        $hourCondition = ($hour >= self::HOUR_START && $hour < self::HOUR_END);

        if (!$dayOfWeekCondition || !$hourCondition) {
            throw new OutOfTimeChooseDishException();
        }
    }
}
