<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers\Matcher;

use JamesHalsall\PhpSpecContainsMatchers\Matcher\ContainAnyOfMatcher;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\Matcher;
use PhpSpec\ObjectBehavior;

class ContainAnyOfMatcherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ContainAnyOfMatcher::class);
    }

    function it_is_a_matcher()
    {
        $this->shouldHaveType(Matcher::class);
    }

    function it_supports_valid_matcher()
    {
        $this->supports('containAnyOf', [1, 2], [1, 2])->shouldReturn(true);
    }

    function it_does_not_support_invalid_matcher()
    {
        $this->supports('containOne', [1, 2], [1, 2])->shouldReturn(false);
    }

    function it_does_not_support_invalid_subject()
    {
        $this->supports('containAnyOf', null, [1, 2])->shouldReturn(false);
    }

    function it_does_not_support_empty_arguments()
    {
        $this->supports('containAnyOf', [1, 2], [])->shouldReturn(false);
    }

    function it_makes_a_positive_match()
    {
        $this->positiveMatch('containAnyOf', [1, 2], [1, 3, 4])->shouldReturn(null);
        $this->positiveMatch('containAnyOf', ['foo', 'bar'], ['foo', 'bar', 'baz'])->shouldReturn(null);
    }

    function it_throws_exception_for_failed_positive_match()
    {
        $this->shouldThrow(FailureException::class)->duringPositiveMatch('containAnyOf', [1, 2], [3, 4]);
        $this->shouldThrow(FailureException::class)->duringPositiveMatch('containAnyOf', ['foo', 'bar'], ['baz', 'buzz']);
    }

    function it_makes_a_negative_match()
    {
        $this->negativeMatch('containAnyOf', [1, 2], [3, 4])->shouldReturn(null);
        $this->negativeMatch('containAnyOf', ['foo', 'bar'], ['baz', 'buzz'])->shouldReturn(null);
    }

    function it_throws_exception_for_failed_negative_match()
    {
        $this->shouldThrow(FailureException::class)->duringNegativeMatch('containAnyOf', [1, 2], [2, 3]);
    }
}
