<?php

namespace JamesHalsall\PhpSpecContainsMatchers\Exception\Factory;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Formatter\Presenter\Presenter;

class ArrayContainOnlyExceptionFactory implements ExceptionFactory
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
                'Expected %s but got %s',
                $this->presenter->presentValue($arguments),
                $this->presenter->presentValue($subject)
            )
        );
    }

    public function createNegativeMatchFailureException(array $subject, array $arguments)
    {
        return new FailureException(
            sprintf(
                'Expected %s to contain at least one other element, but it does not',
                $this->presenter->presentValue($arguments)
            )
        );
    }
}
