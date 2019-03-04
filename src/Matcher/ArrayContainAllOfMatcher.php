<?php

namespace JamesHalsall\PhpSpecContainsMatchers\Matcher;

use JamesHalsall\PhpSpecContainsMatchers\Exception\Factory\ExceptionFactory;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\Matcher;
use PhpSpec\Wrapper\DelayedCall;

class ArrayContainAllOfMatcher implements Matcher
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
        return 'containAllOf' === $name
            && count($arguments) > 1
            && is_array($subject);
    }

    public function positiveMatch(string $name, $subject, array $arguments): ?DelayedCall
    {
        $missingValues = array_diff($arguments, $subject);

        if (count($missingValues) > 0) {
            throw $this->exceptionFactory->createPositiveMatchFailureException($subject, $arguments);
        }

        return null;
    }

    public function negativeMatch(string $name, $subject, array $arguments): ?DelayedCall
    {
        try {
            $this->positiveMatch($name, $subject, $arguments);
        } catch (FailureException $e) {
            return null;
        }

        throw $this->exceptionFactory->createNegativeMatchFailureException($subject, $arguments);
    }

    public function getPriority(): int
    {
        return 0;
    }
}
