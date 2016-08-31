<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers\Exception\Factory;

use JamesHalsall\PhpSpecContainsMatchers\Exception\Factory\ArrayContainAnyOfExceptionFactory;
use JamesHalsall\PhpSpecContainsMatchers\Exception\Factory\ExceptionFactory;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArrayContainAnyOfExceptionFactorySpec extends ObjectBehavior
{
    function let(Presenter $presenter)
    {
        $this->beConstructedWith($presenter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ArrayContainAnyOfExceptionFactory::class);
    }

    function it_is_an_execption_factory()
    {
        $this->shouldHaveType(ExceptionFactory::class);
    }

    function it_creates_a_positive_match_failure_exception(Presenter $presenter)
    {
        $subject = ['foo', 'bar'];
        $arguments = ['baz'];

        $presenter->presentValue($subject)->shouldBeCalled()->willReturn('["foo", "bar"]');
        $presenter->presentValue($arguments)->shouldBeCalled()->willReturn('["baz"]');

        $exception = $this->createPositiveMatchFailureException($subject, $arguments);
        $exception->shouldBeAnInstanceOf(FailureException::class);
        $exception->getMessage()->shouldEqual('Expected to find at least one of ["baz"] in ["foo", "bar"], but did not.');
    }

    function it_creates_a_negative_match_failure_exception(Presenter $presenter)
    {
        $subject = ['foo', 'bar'];
        $arguments = ['bar'];

        $presenter->presentValue($subject)->shouldBeCalled()->willReturn('["foo", "bar"]');
        $presenter->presentValue($arguments)->shouldBeCalled()->willReturn('["bar"]');

        $exception = $this->createNegativeMatchFailureException($subject, $arguments);
        $exception->shouldBeAnInstanceOf(FailureException::class);
        $exception->getMessage()->shouldEqual('Found one of ["bar"] in ["foo", "bar"], which was not expected.');
    }
}
