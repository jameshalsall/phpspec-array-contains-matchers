<?php

namespace JamesHalsall\PhpSpecContainsMatchers;

use PhpSpec\Extension as PhpSpecExtension;
use PhpSpec\ServiceContainer;

class Extension implements PhpSpecExtension
{
    public function load(ServiceContainer $container, array $params)
    {
        $container->define('jameshalsall.matchers.contain_any_of', function () {
            return new Matcher\ArrayContainAnyOfMatcher();
        }, ['matchers']);

        $container->define('jameshalsall.matchers.contain_only', function () {
            return new Matcher\ArrayContainOnlyMatcher();
        }, ['matchers']);

        $container->define('jameshalsall.matchers.contain_all_of', function () {
            return new Matcher\ArrayContainAllOfMatcher();
        }, ['matchers']);
    }
}
