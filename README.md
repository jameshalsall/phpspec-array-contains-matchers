# PHPSpec Array Contains Matchers

[![Build Status](https://travis-ci.org/jameshalsall/phpspec-array-contains-matchers.svg?branch=master)](https://travis-ci.org/jameshalsall/phpspec-array-contains-matchers)

Provides additional contains matchers for arrays in PHPSpec

## Requirements

The extensions has been built for PHPSpec 3.x and PHP 5.6 or later.

## Installation

Install the extension via composer:

```
$ composer require jameshalsall/phpspec-array-contains-matchers
```

You can then add the extension to your `phpspec.yml` as follows:

```yaml
extensions:
  JamesHalsall\PhpSpecContainsMatchers\Extension: ~
```

## Usage

There are currently two matchers that are provided by this extension, `shouldContainOnly` and `shouldContainAnyOf`

## `containOnly` matcher

The `containOnly` matcher is used when you want to ensure that an array value contains *only* the specified arguments.
It was implemented to save you writing multiple calls to `shouldContain()`.

Consider that `->getArray()` returns `[1, 2, 3]`, the following code in your spec would pass:

```php
$this->getArray()->shouldContainOnly(1, 2, 3);
```

If any anything else was in the array would it would cause the spec to fail.

Similarly this can be negated with `shouldNotContainOnly`. Staying with the same example above, the following code 
would fail because there aren't any additional values in the array:

```
$this->getArray()->shouldNotContainOnly(1, 2, 3);
```

However if `->getArray()` was to return `[1, 2, 3, 4]` then the above spec would pass.

## `containAnyOf` matcher

The `containAnyOf` matcher is used when you want to ensure that an array contains **at least one** of the specified arguments.

Consider that `->getArray()` returns `[1, 2, 3]` as above, the following assertion would hold true:

```php
$this->getArray()->shouldContainAnyOf(3, 4, 5);
```

However the following example would not:

```
$this->getArray()->shouldContainAnyOf(5, 6);
```

Similarly this can be negated with `shouldNotContainAnyOf`. Staying with the sample example, the following code would fail:

```php
$this->getArray()->shouldNotContainAnyOf(3, 7);
```

This is because it contains the value 3, which is one of the values we have said it should *not* contain.
