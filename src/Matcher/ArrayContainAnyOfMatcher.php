<?php

namespace JamesHalsall\PhpSpecContainsMatchers\Matcher;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\Matcher;
use Prophecy\Comparator\Factory;
use SebastianBergmann\Comparator\ArrayComparator;

class ArrayContainAnyOfMatcher implements Matcher
{
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

        throw new FailureException(
            sprintf(
                'Expected to find at least one of [%s] in [%s], but did not.',
                implode(', ', $arguments),
                implode(', ', $subject)
            )
        );
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
                'Found one of [%s] in [%s], which is not expected.',
                implode(', ', $arguments),
                implode(', ', $subject)
            )
        );
    }

    /**
     * Returns matcher priority.
     *
     * @return integer
     */
    public function getPriority()
    {
        // TODO: Implement getPriority() method.
    }
}
