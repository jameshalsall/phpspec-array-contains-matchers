<?php

namespace JamesHalsall\PhpSpecContainsMatchers\Matcher;

use JamesHalsall\PhpSpecContainsMatchers\Exception\Factory\ExceptionFactory;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\Matcher;
use Prophecy\Comparator\Factory;
use SebastianBergmann\Comparator\ArrayComparator;

class ArrayContainAnyOfMatcher implements Matcher
{
    /**
     * @var ExceptionFactory
     */
    private $exceptionFactory;

    public function __construct(ExceptionFactory $exceptionFactory)
    {
        $this->exceptionFactory = $exceptionFactory;
    }

    public function supports(string $name, $subject, array $arguments): bool
    {
        $comparator = new ArrayComparator();
        $comparator->setFactory(new Factory());

        return 'containAnyOf' === $name
            && count($arguments) > 1
            && $comparator->accepts($subject, $arguments);
    }

    public function positiveMatch(string $name, $subject, array $arguments): bool
    {
        foreach ($arguments as $argument) {
            if (in_array($argument, $subject, true)) {
                return true;
            }
        }

        throw $this->exceptionFactory->createPositiveMatchFailureException($subject, $arguments);
    }

    public function negativeMatch(string $name, $subject, array $arguments): bool
    {
        try {
            $this->positiveMatch($name, $subject, $arguments);
        } catch (FailureException $e) {
            return true;
        }

        throw $this->exceptionFactory->createNegativeMatchFailureException($subject, $arguments);
    }

    public function getPriority(): int
    {
        return 0;
    }
}
