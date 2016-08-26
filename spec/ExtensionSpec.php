<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers;

use JamesHalsall\PhpSpecContainsMatchers\Extension;
use PhpSpec\Extension as PhpSpecExtension;
use PhpSpec\ObjectBehavior;
use PhpSpec\ServiceContainer;
use Prophecy\Argument;

class ExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Extension::class);
    }

    function it_is_an_extension()
    {
        $this->shouldHaveType(PhpSpecExtension::class);
    }

    function it_should_define_a_contain_any_of_matcher(ServiceContainer $container)
    {
        $this->load($container, []);

        $container->define('jameshalsall.matchers.contain_any_of', Argument::type('callable'), ['matchers'])->shouldHaveBeenCalled();
    }

    function it_should_define_a_contain_only_matcher(ServiceContainer $container)
    {
        $this->load($container, []);

        $container->define('jameshalsall.matchers.contain_only', Argument::type('callable'), ['matchers'])->shouldHaveBeenCalled();
    }
}
