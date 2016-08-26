<?php

namespace JamesHalsall\PhpSpecContainsMatchers\Matcher;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\Matcher;
use Prophecy\Comparator\Factory;
use SebastianBergmann\Comparator\ArrayComparator;
use SebastianBergmann\Comparator\ComparisonFailure;

class ContainOnlyMatcher implements Matcher
{
    public function supports($name, $subject, array $arguments)
    {
        $comparator = new ArrayComparator();

        return 'containOnly' === $name
            && count($arguments) > 1
            && $comparator->accepts($subject, $arguments);
    }

    public function positiveMatch($name, $subject, array $arguments)
    {
        try {
            $this->getComparator()->assertEquals($subject, $arguments, 0, true);
        } catch (ComparisonFailure $e) {
            throw new FailureException(
                sprintf(
                    'The containOnly() matcher failed: Expected array of [%s] but got [%s]',
                    implode(', ', $arguments),
                    implode(', ', $subject)
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
                'The containOnly() matcher should have failed: Array of [%s] should not have matched [%s]',
                implode(', ', $arguments),
                implode(',', $subject)
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
        return 0;
    }

    private function getComparator()
    {
        $comparator = new ArrayComparator();
        $comparator->setFactory(new Factory());

        return $comparator;
    }
}
