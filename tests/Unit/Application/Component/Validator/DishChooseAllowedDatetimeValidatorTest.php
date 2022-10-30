<?php

declare(strict_types=1);

namespace tests\Meals\Unit\Application\Component\Validator;

use Meals\Application\Component\Validator\DishChooseAllowedDatetimeValidator;
use Meals\Application\Component\Validator\Exception\OutOfTimeChooseDishException;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class DishChooseAllowedDatetimeValidatorTest extends TestCase
{
    use ProphecyTrait;

    public function testSuccessful()
    {
        $dateTime = new \DateTimeImmutable('monday 6:00');

        $validator = new DishChooseAllowedDatetimeValidator();
        verify($validator->validate($dateTime))->null();
    }

    public function testFailCorrectDayBadTime()
    {
        $this->expectException(OutOfTimeChooseDishException::class);

        $dateTime = new \DateTimeImmutable('monday 22:00');
        $validator = new DishChooseAllowedDatetimeValidator();
        $validator->validate($dateTime);
    }

    public function testFailBadDayCorrectTime()
    {
        $this->expectException(OutOfTimeChooseDishException::class);

        $dateTime = new \DateTimeImmutable('tuesday 13:00');
        $validator = new DishChooseAllowedDatetimeValidator();
        $validator->validate($dateTime);
    }

    public function testFailBadDayBadTime()
    {
        $this->expectException(OutOfTimeChooseDishException::class);

        $dateTime = new \DateTimeImmutable('tuesday 04:00');
        $validator = new DishChooseAllowedDatetimeValidator();
        $validator->validate($dateTime);
    }
}