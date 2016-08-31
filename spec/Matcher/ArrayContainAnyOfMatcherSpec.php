<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers\Matcher;

use JamesHalsall\PhpSpecContainsMatchers\Exception\Factory\ExceptionFactory;
use JamesHalsall\PhpSpecContainsMatchers\Matcher\ArrayContainAnyOfMatcher;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\Matcher;
use PhpSpec\ObjectBehavior;

class ArrayContainAnyOfMatcherSpec extends ObjectBehavior
{
    function let(ExceptionFactory $exceptionFactory)
    {
        $this->beConstructedWith($exceptionFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ArrayContainAnyOfMatcher::class);
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

    function it_makes_a_positive_match(ExceptionFactory $exceptionFactory)
    {
        $exceptionFactory->createPositiveMatchFailureException()->shouldNotBeCalled();

        $this->positiveMatch('containAnyOf', [1, 2], [1, 3, 4])->shouldReturn(null);
        $this->positiveMatch('containAnyOf', ['foo', 'bar'], ['foo', 'bar', 'baz'])->shouldReturn(null);
    }

    function it_throws_exception_for_failed_positive_match(ExceptionFactory $exceptionFactory)
    {
        $exceptionFactory->createPositiveMatchFailureException([1, 2], [3, 4])->shouldBeCalled()->willReturn(new FailureException());
        $exceptionFactory->createPositiveMatchFailureException(['foo', 'bar'], ['baz', 'buzz'])->shouldBeCalled()->willReturn(new FailureException());

        $this->shouldThrow(FailureException::class)->duringPositiveMatch('containAnyOf', [1, 2], [3, 4]);
        $this->shouldThrow(FailureException::class)->duringPositiveMatch('containAnyOf', ['foo', 'bar'], ['baz', 'buzz']);
    }

    function it_makes_a_negative_match(ExceptionFactory $exceptionFactory)
    {
        $exceptionFactory->createPositiveMatchFailureException([1, 2], [3, 4])->shouldBeCalled()->willReturn(new FailureException());
        $exceptionFactory->createPositiveMatchFailureException(['foo', 'bar'], ['baz', 'buzz'])->shouldBeCalled()->willReturn(new FailureException());

        $this->negativeMatch('containAnyOf', [1, 2], [3, 4])->shouldReturn(null);
        $this->negativeMatch('containAnyOf', ['foo', 'bar'], ['baz', 'buzz'])->shouldReturn(null);
    }

    function it_throws_exception_for_failed_negative_match(ExceptionFactory $exceptionFactory)
    {
        $exceptionFactory->createNegativeMatchFailureException([1, 2], [2, 3])->shouldBeCalled()->willReturn(new FailureException());

        $this->shouldThrow(FailureException::class)->duringNegativeMatch('containAnyOf', [1, 2], [2, 3]);
    }

    function it_has_no_priority()
    {
        $this->getPriority()->shouldReturn(0);
    }
}
