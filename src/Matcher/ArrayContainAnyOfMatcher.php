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

    public function supports($name, $subject, array $arguments)
    {
        $comparator = new ArrayComparator();
        $comparator->setFactory(new Factory());

        return 'containAnyOf' === $name
            && count($arguments) > 1
            && $comparator->accepts($subject, $arguments);
    }

    public function positiveMatch($name, $subject, array $arguments)
    {
        foreach ($arguments as $argument) {
            if (in_array($argument, $subject, true)) {
                return;
            }
        }

        throw $this->exceptionFactory->createPositiveMatchFailureException($subject, $arguments);
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

    /**
     * Returns matcher priority.
     *
     * @return integer
     */
    public function getPriority()
    {
        return 0;
    }
}
