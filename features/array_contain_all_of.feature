Feature: Using the containAllOf matcher
  In order to use the containAllOf matcher
  I need to enable the PhpSpecContainsMatchers extension


  Background:
    Given the config file contains:
    """
    extensions:
      JamesHalsall\PhpSpecContainsMatchers\Extension: ~
    """

  Scenario: The containAllOf matcher makes a positive match for valid subject
    Given the spec file "spec/ContainAllOf1Spec.php" contains:
    """
<?php

namespace spec;

class ContainAllOf1Spec extends \PhpSpec\ObjectBehavior
{
    function it_contains_all_of()
    {
        $this->getArray()->shouldContainAllOf('foo', 'baz');
    }
}
    """

    And the class file "src/ContainAllOf1.php" contains:
    """
<?php

class ContainAllOf1
{
    public function getArray()
    {
        return ['foo', 'bar', 'baz'];
    }
}
    """

    When I run phpspec
    Then the suite should pass

  Scenario: The containAllOf matcher does not make a positive match for invalid subject
    Given the spec file "spec/JamesHalsall/PhpSpecContainsMatchers/ContainAllOf2Spec.php" contains:
    """
<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers;

class ContainAllOf2Spec extends \PhpSpec\ObjectBehavior
{
    function it_contains_all_of()
    {
        $this->getArray()->shouldContainAllOf(2, 3);
    }
}
    """

    And the class file "src/ContainAllOf2.php" contains:
    """
<?php

namespace JamesHalsall\PhpSpecContainsMatchers;

class ContainAllOf2
{
    public function getArray()
    {
        return [1, 2];
    }
}
    """

    When I run phpspec
    Then the suite should not pass

  Scenario: The containAllOf matcher makes a negative match for invalid subject
    Given the spec file "spec/JamesHalsall/PhpSpecContainsMatchers/ContainAllOf3Spec.php" contains:
    """
<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers;

class ContainAllOf3Spec extends \PhpSpec\ObjectBehavior
{
    function it_does_not_contain_all_of()
    {
        $this->getArray()->shouldNotContainAllOf(2, 4);
    }
}
    """

    And the class file "src/ContainAllOf3.php" contains:
    """
<?php

namespace JamesHalsall\PhpSpecContainsMatchers;

class ContainAllOf3
{
    public function getArray()
    {
        return [1, 2];
    }
}
    """

    When I run phpspec
    Then the suite should pass

  Scenario: The containAllOf matcher does not make a negative match for valid subject
    Given the spec file "spec/JamesHalsall/PhpSpecContainsMatchers/ContainAllOf4Spec.php" contains:
    """
<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers;

class ContainAllOf4Spec extends \PhpSpec\ObjectBehavior
{
    function it_does_not_contain_all_of()
    {
        $this->getArray()->shouldNotContainAllOf(2, 1);
    }
}
    """

    And the class file "src/ContainAllOf4.php" contains:
    """
<?php

namespace JamesHalsall\PhpSpecContainsMatchers;

class ContainAllOf4
{
    public function getArray()
    {
        return [1, 2];
    }
}
    """

    When I run phpspec
    Then the suite should not pass
