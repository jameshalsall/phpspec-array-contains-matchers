<?php

namespace JamesHalsall\PhpSpecContainsMatchers\Matcher;

use JamesHalsall\PhpSpecContainsMatchers\Exception\Factory\ExceptionFactory;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\Matcher;

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

    public function supports($name, $subject, array $arguments)
    {
        return 'containAllOf' === $name
            && count($arguments) > 1
            && is_array($subject);
    }

    public function positiveMatch($name, $subject, array $arguments)
    {
        $missingValues = array_diff($arguments, $subject);

        if (count($missingValues) > 0) {
            throw $this->exceptionFactory->createPositiveMatchFailureException($subject, $arguments);
        }
    }

    public function negativeMatch($name, $subject, array $arguments)
    {
        try {
            $this->positiveMatch($name, $subject, $arguments);
        } catch (FailureException $e) {
            return;
        }

        throw $this->exceptionFactory->createNegativeMatchFailureException($subject, $arguments);
    }

    public function getPriority()
    {
        return 0;
    }
}
