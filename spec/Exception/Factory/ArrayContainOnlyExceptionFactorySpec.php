<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers\Exception\Factory;

use JamesHalsall\PhpSpecContainsMatchers\Exception\Factory\ArrayContainOnlyExceptionFactory;
use JamesHalsall\PhpSpecContainsMatchers\Exception\Factory\ExceptionFactory;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\ObjectBehavior;

class ArrayContainOnlyExceptionFactorySpec extends ObjectBehavior
{
    function let(Presenter $presenter)
    {
        $this->beConstructedWith($presenter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ArrayContainOnlyExceptionFactory::class);
    }

    function it_is_an_exception_factory()
    {
        $this->shouldHaveType(ExceptionFactory::class);
    }

    function it_creates_a_positive_match_failure_exception(Presenter $presenter)
    {
        $subject = [1, 2, 3];
        $arguments = ['foo', 'bar'];

        $presenter->presentValue($subject)->shouldBeCalled()->willReturn('[1, 2, 3]');
        $presenter->presentValue($arguments)->shouldBeCalled()->willReturn('["foo", "bar"]');

        $exception = $this->createPositiveMatchFailureException($subject, $arguments);
        $exception->shouldBeAnInstanceOf(FailureException::class);
        $exception->getMessage()->shouldEqual('Expected ["foo", "bar"] but got [1, 2, 3]');
    }

    function it_creates_a_negative_match_failure_exception(Presenter $presenter)
    {
        $subject = ["foo", "bar"];
        $arguments = ["foo", "bar"];

        $presenter->presentValue($subject)->shouldBeCalled()->willReturn('["foo", "bar"]');

        $exception = $this->createNegativeMatchFailureException($subject, $arguments);
        $exception->shouldBeAnInstanceOf(FailureException::class);
        $exception->getMessage()->shouldEqual('Expected ["foo", "bar"] to contain at least one other element, but it does not');
    }
}
