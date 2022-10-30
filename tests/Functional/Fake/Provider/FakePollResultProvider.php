<?php

declare(strict_types=1);

namespace tests\Meals\Functional\Fake\Provider;

use Meals\Application\Component\Provider\PollResultProviderInterface;
use Meals\Domain\Dish\Dish;
use Meals\Domain\Employee\Employee;
use Meals\Domain\Poll\Poll;
use Meals\Domain\Poll\PollResult;

class FakePollResultProvider implements PollResultProviderInterface
{
    private PollResult $pollResult;
    private array $pollResults = [];

    public function createPollResult(Poll $poll, Employee $employee, Dish $dish): PollResult
    {
        return new PollResult(1, $poll, $employee, $dish, $employee->getFloor());
    }

    public function getPollResults(): array
    {
        return $this->pollResults;
    }

    public function setPollResults(array $pollResults): void
    {
        $this->pollResults = $pollResults;
    }

    public function getPollResult(int $pollResultId): PollResult
    {
        return $this->pollResult;
    }

    public function setPollResult(PollResult $pollResult): void
    {
        $this->pollResult = $pollResult;
    }
}