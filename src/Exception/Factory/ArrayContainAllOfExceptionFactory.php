<?php

namespace JamesHalsall\PhpSpecContainsMatchers\Exception\Factory;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Formatter\Presenter\Presenter;

class ArrayContainAllOfExceptionFactory implements ExceptionFactory
{
    /**
     * @var Presenter
     */
    private $presenter;

    public function __construct(Presenter $presenter)
    {
        $this->presenter = $presenter;
    }

    public function createPositiveMatchFailureException(array $subject, array $arguments)
    {
        return new FailureException(
            sprintf(
                'Expected to find all of %s in %s, but it is missing %s.',
                $this->presenter->presentValue($arguments),
                $this->presenter->presentValue($subject),
                $this->presenter->presentValue(array_diff($arguments, $subject))
            )
        );
    }

    public function createNegativeMatchFailureException(array $subject, array $arguments)
    {
        return new FailureException(
            sprintf(
                'Found all of %s in %s, did not expect that.',
                $this->presenter->presentValue($arguments),
                $this->presenter->presentValue($subject)
            )
        );
    }
}
