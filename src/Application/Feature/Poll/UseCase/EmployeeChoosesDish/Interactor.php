<?php

declare(strict_types=1);

namespace Meals\Application\Feature\Poll\UseCase\EmployeeChoosesDish;

use Meals\Application\Component\Provider\DishProviderInterface;
use Meals\Application\Component\Provider\EmployeeProviderInterface;
use Meals\Application\Component\Provider\PollProviderInterface;
use Meals\Application\Component\Provider\PollResultProviderInterface;
use Meals\Application\Component\Validator\DishListHasDishValidator;
use Meals\Application\Component\Validator\DishChooseAllowedDatetimeValidator;
use Meals\Application\Component\Validator\EmployeeCanChooseDishValidator;
use Meals\Application\Component\Validator\PollIsActiveValidator;
use Meals\Application\Component\Validator\UserCanParticipateInPollsValidator;
use Meals\Application\Component\Validator\UserHasAccessToViewPollsValidator;
use Meals\Domain\Poll\PollResult;

class Interactor
{
    public function __construct(
        private EmployeeProviderInterface          $employeeProvider,
        private PollProviderInterface              $pollProvider,
        private DishProviderInterface              $dishProvider,
        private PollResultProviderInterface        $pollResultProvider,
        private EmployeeCanChooseDishValidator     $employeeCanChooseDishValidator,
        private UserHasAccessToViewPollsValidator  $userHasAccessToViewPollsValidator,
        private UserCanParticipateInPollsValidator $userCanParticipateInPollsValidator,
        private PollIsActiveValidator              $pollIsActiveValidator,
        private DishListHasDishValidator           $dishListHasDishValidator,
        private DishChooseAllowedDatetimeValidator $dishChooseAllowedDatetimeValidator
    ) {}

    public function chooseDish(int $employeeId, int $pollId, int $dishId, \DateTimeInterface $dateTime): PollResult
    {
        $pollResults = $this->pollResultProvider->getPollResults();
        $employee = $this->employeeProvider->getEmployee($employeeId);
        $poll = $this->pollProvider->getPoll($pollId);
        $dishList = $poll->getMenu()->getDishes();
        $dish = $this->dishProvider->getDish($dishId);

        $this->employeeCanChooseDishValidator->validate($employee, $pollResults);
        $this->userHasAccessToViewPollsValidator->validate($employee->getUser());
        $this->pollIsActiveValidator->validate($poll);
        $this->userCanParticipateInPollsValidator->validate($employee->getUser());
        $this->dishListHasDishValidator->validate($dishList, $dish);
        $this->dishChooseAllowedDatetimeValidator->validate($dateTime);

        return $this->pollResultProvider->createPollResult($poll, $employee, $dish);
    }
}