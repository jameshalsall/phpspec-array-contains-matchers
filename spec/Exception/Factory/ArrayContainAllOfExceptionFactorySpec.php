<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers\Exception\Factory;

use JamesHalsall\PhpSpecContainsMatchers\Exception\Factory\ArrayContainAllOfExceptionFactory;
use JamesHalsall\PhpSpecContainsMatchers\Exception\Factory\ExceptionFactory;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArrayContainAllOfExceptionFactorySpec extends ObjectBehavior
{
    function let(Presenter $presenter)
    {
        $this->beConstructedWith($presenter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ArrayContainAllOfExceptionFactory::class);
    }

    function it_is_an_exception_factory()
    {
        $this->shouldHaveType(ExceptionFactory::class);
    }

    function it_creates_a_positive_match_failure_exception(Presenter $presenter)
    {
        $subject = [1, 2, 3];
        $arguments = [1, 2, 'foo'];

        $presenter->presentValue($subject)->shouldBeCalled()->willReturn('[1, 2, 3]');
        $presenter->presentValue($arguments)->shouldBeCalled()->willReturn('[1, 2, "foo"]');
        $presenter
            ->presentValue(
                Argument::allOf(Argument::containing('foo'), Argument::size(1))
            )
            ->shouldBeCalled()
            ->willReturn('["foo"]')
        ;

        $exception = $this->createPositiveMatchFailureException($subject, $arguments);
        $exception->shouldBeAnInstanceOf(FailureException::class);
        $exception->getMessage()->shouldEqual('Expected to find all of [1, 2, "foo"] in [1, 2, 3], but it is missing ["foo"].');
    }

    function it_creates_a_negative_match_failure_exception(Presenter $presenter)
    {
        $subject = [1, 2, 3, 4];
        $arguments = [2, 3];

        $presenter->presentValue($subject)->shouldBeCalled()->willReturn('[1, 2, 3, 4]');
        $presenter->presentValue($arguments)->shouldBeCalled()->willReturn('[2, 3]');

        $exception = $this->createNegativeMatchFailureException($subject, $arguments);
        $exception->shouldBeAnInstanceOf(FailureException::class);
        $exception->getMessage()->shouldEqual('Found all of [2, 3] in [1, 2, 3, 4], did not expect that.');
    }
}
