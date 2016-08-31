<?php

namespace JamesHalsall\PhpSpecContainsMatchers\Exception\Factory;

use PhpSpec\Exception\Example\FailureException;

interface ExceptionFactory
{
    /**
     * @param array $subject
     * @param array $arguments
     *
     * @return FailureException
     */
    public function createPositiveMatchFailureException(array $subject, array $arguments);

    /**
     * @param array $subject
     * @param array $arguments
     *
     * @return FailureException
     */
    public function createNegativeMatchFailureException(array $subject, array $arguments);
}
