<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers\Matcher;

use JamesHalsall\PhpSpecContainsMatchers\Exception\Factory\ExceptionFactory;
use JamesHalsall\PhpSpecContainsMatchers\Matcher\ArrayContainAllOfMatcher;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\Matcher;
use PhpSpec\ObjectBehavior;

class ArrayContainAllOfMatcherSpec extends ObjectBehavior
{
    function let(ExceptionFactory $exceptionFactory)
    {
        $this->beConstructedWith($exceptionFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ArrayContainAllOfMatcher::class);
    }

    function it_is_a_matcher()
    {
        $this->shouldHaveType(Matcher::class);
    }

    function it_supports_valid_matcher()
    {
        $this->supports('containAllOf', [], [1, 2])->shouldReturn(true);
    }

    function it_does_not_support_invalid_matcher()
    {
        $this->supports('containNoneOf', [], [1, 2])->shouldReturn(false);
    }

    function it_does_not_support_invalid_subject()
    {
        $this->supports('containAllOf', null, [1, 2])->shouldReturn(false);
    }

    function it_does_not_support_empty_arguments()
    {
        $this->supports('containAllOf', [], [])->shouldReturn(false);
    }

    function it_makes_a_positive_match(ExceptionFactory $exceptionFactory)
    {
        $exceptionFactory->createPositiveMatchFailureException()->shouldNotBeCalled();

        $this->positiveMatch('containAllOf', ['foo', 'bar', 'baz'], ['foo', 'baz'])->shouldReturn(null);
    }

    function it_throws_exception_for_failed_positive_match(ExceptionFactory $exceptionFactory)
    {
        $exceptionFactory->createPositiveMatchFailureException(['foo', 'bar', 'baz'], ['buz', 'baz'])->shouldBeCalled()->willReturn(new FailureException());

        $this->shouldThrow(FailureException::class)->duringPositiveMatch('containAllOf', ['foo', 'bar', 'baz'], ['buz', 'baz']);
    }

    function it_makes_a_negative_match(ExceptionFactory $exceptionFactory)
    {
        $exceptionFactory->createPositiveMatchFailureException([1, 2], [2, 3])->shouldBeCalled()->willReturn(new FailureException());

        $this->negativeMatch('containAllOf', [1, 2], [2, 3])->shouldReturn(null);
    }

    function it_throws_exception_for_failed_negative_match(ExceptionFactory $exceptionFactory)
    {
        $exceptionFactory->createNegativeMatchFailureException(['foo', 1, 2], ['foo', 1])->shouldBeCalled()->willReturn(new FailureException());

        $this->shouldThrow(FailureException::class)->duringNegativeMatch('containAllOf', ['foo', 1, 2], ['foo', 1]);
    }

    function it_has_no_priority()
    {
        $this->getPriority()->shouldReturn(0);
    }
}
