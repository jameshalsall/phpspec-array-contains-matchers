<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers\Matcher;

use JamesHalsall\PhpSpecContainsMatchers\Exception\Factory\ExceptionFactory;
use JamesHalsall\PhpSpecContainsMatchers\Matcher\ArrayContainOnlyMatcher;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\Matcher;
use PhpSpec\ObjectBehavior;

class ArrayContainOnlyMatcherSpec extends ObjectBehavior
{
    function let(ExceptionFactory $exceptionFactory)
    {
        $this->beConstructedWith($exceptionFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ArrayContainOnlyMatcher::class);
    }

    function it_is_a_matcher()
    {
        $this->shouldHaveType(Matcher::class);
    }

    function it_supports_valid_matcher()
    {
        $this->supports('containOnly', [], [1, 2, 3])->shouldReturn(true);
    }

    function it_does_not_support_invalid_matcher()
    {
        $this->supports('contain', [], [1, 2, 3])->shouldReturn(false);
    }

    function it_does_not_support_invalid_subject()
    {
        $this->supports('containOnly', 'invalid', [1, 2, 3])->shouldThrow(false);
    }

    function it_does_not_support_empty_arguments()
    {
        $this->supports('containOnly', [1, 2], [])->shouldReturn(false);
    }

    function it_makes_a_positive_match(ExceptionFactory $exceptionFactory)
    {
        $exceptionFactory->createPositiveMatchFailureException()->shouldNotBeCalled();

        $this->positiveMatch('containOnly', [1, 2], [1, 2])->shouldReturn(null);
        $this->positiveMatch('containOnly', ['foo', 'bar'], ['bar', 'foo'])->shouldReturn(null);
    }

    function it_throws_exception_for_failed_positive_match(ExceptionFactory $exceptionFactory)
    {
        $exceptionFactory->createPositiveMatchFailureException([1, 2], [1])->shouldBeCalled()->willReturn(new FailureException());
        $exceptionFactory->createPositiveMatchFailureException(['foo', 'bar'], ['bar'])->shouldBeCalled()->willReturn(new FailureException());

        $this->shouldThrow(FailureException::class)->duringPositiveMatch('containOnly', [1, 2], [1]);
        $this->shouldThrow(FailureException::class)->duringPositiveMatch('containOnly', ['foo', 'bar'], ['bar']);
    }

    function it_makes_a_negative_match(ExceptionFactory $exceptionFactory)
    {
        $exceptionFactory->createPositiveMatchFailureException([1, 2], [1, 2, 3])->shouldbeCalled()->willReturn(new FailureException());

        $this->negativeMatch('containOnly', [1 ,2], [1, 2, 3])->shouldReturn(null);
    }

    function it_throws_exception_for_failed_negative_match(ExceptionFactory $exceptionFactory)
    {
        $exceptionFactory->createNegativeMatchFailureException([1, 2], [1, 2])->shouldBeCalled()->willReturn(new FailureException());
        $exceptionFactory->createNegativeMatchFailureException(['foo', 'bar'], ['foo', 'bar'])->shouldBeCalled()->willReturn(new FailureException());

        $this->shouldThrow(FailureException::class)->duringNegativeMatch('containOnly', [1, 2], [1, 2]);
        $this->shouldThrow(FailureException::class)->duringNegativeMatch('containOnly', ['foo', 'bar'], ['foo', 'bar']);
    }

    function it_has_no_priority()
    {
        return 0;
    }
}
