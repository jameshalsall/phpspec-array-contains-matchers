<?php

namespace JamesHalsall\PhpSpecContainsMatchers\Exception\Factory;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Formatter\Presenter\Presenter;

class ArrayContainAnyOfExceptionFactory implements ExceptionFactory
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
                'Expected to find at least one of %s in %s, but did not.',
                $this->presenter->presentValue($arguments),
                $this->presenter->presentValue($subject)
            )
        );
    }

    public function createNegativeMatchFailureException(array $subject, array $arguments)
    {
        return new FailureException(
            sprintf(
                'Found one of %s in %s, which was not expected.',
                $this->presenter->presentValue($arguments),
                $this->presenter->presentValue($subject)
            )
        );
    }
}
