<?php

declare(strict_types=1);

namespace Meals\Application\Component\Validator;

use Meals\Application\Component\Validator\Exception\EmployeeAlreadyChoseDishException;
use Meals\Domain\Employee\Employee;
use Meals\Domain\Poll\PollResult;

class EmployeeCanChooseDishValidator
{
    public function validate(Employee $employee, array $pollResults): void
    {
        foreach ($pollResults as $pollResult) {
            if ($pollResult instanceof PollResult) {
                if ($employee->getId() === $pollResult->getEmployee()->getId()) {
                    throw new EmployeeAlreadyChoseDishException();
                }
            }
        }
    }
}