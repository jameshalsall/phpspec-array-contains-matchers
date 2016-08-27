<?php

namespace JamesHalsall\PhpSpecContainsMatchers\Matcher;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\Matcher;

class ArrayContainAllOfMatcher implements Matcher
{
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
            throw new FailureException(
                sprintf(
                    'Expected to find all of [%s] in [%s], but it is missing [%s]',
                    implode(', ', $arguments),
                    implode(', ', $subject),
                    implode(', ', $missingValues)
                )
            );
        }
    }

    public function negativeMatch($name, $subject, array $arguments)
    {
        try {
            $this->positiveMatch($name, $subject, $arguments);
        } catch (FailureException $e) {
            return;
        }

        throw new FailureException(
            sprintf(
                'Found all of [%s] in [%s], but did not expect that',
                implode(', ', $arguments),
                implode(', ', $subject)
            )
        );
    }

    public function getPriority()
    {
        return 0;
    }
}
