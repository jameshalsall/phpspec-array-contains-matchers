<?php

namespace JamesHalsall\PhpSpecContainsMatchers;

use JamesHalsall\PhpSpecContainsMatchers\Exception\Factory\ArrayContainAllOfExceptionFactory;
use JamesHalsall\PhpSpecContainsMatchers\Exception\Factory\ArrayContainAnyOfExceptionFactory;
use JamesHalsall\PhpSpecContainsMatchers\Exception\Factory\ArrayContainOnlyExceptionFactory;
use PhpSpec\Extension as PhpSpecExtension;
use PhpSpec\ServiceContainer;

class Extension implements PhpSpecExtension
{
    public function load(ServiceContainer $container, array $params)
    {
        $container->define('jameshalsall.matchers.contain_any_of', function ($c) {
            return new Matcher\ArrayContainAnyOfMatcher(new ArrayContainAnyOfExceptionFactory($c->get('formatter.presenter')));
        }, ['matchers']);

        $container->define('jameshalsall.matchers.contain_only', function ($c) {
            return new Matcher\ArrayContainOnlyMatcher(new ArrayContainOnlyExceptionFactory($c->get('formatter.presenter')));
        }, ['matchers']);

        $container->define('jameshalsall.matchers.contain_all_of', function ($c) {
            return new Matcher\ArrayContainAllOfMatcher(new ArrayContainAllOfExceptionFactory($c->get('formatter.presenter')));
        }, ['matchers']);
    }
}
