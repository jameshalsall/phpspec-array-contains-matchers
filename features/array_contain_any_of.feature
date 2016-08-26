Feature: Using the containAnyOf matcher
  In order to use the containAnyOf matcher
  I need to enabled the PhpSpecContainsMatchers extension


  Background:
     Given the config file contains:
    """
    extensions:
      JamesHalsall\PhpSpecContainsMatchers\Extension: ~
    """

  Scenario: The containAnyOf matcher makes a positive match for valid subject
      Given the spec file "spec/ContainAnyOf1Spec.php" contains:
    """
<?php

namespace spec;

class ContainAnyOf1Spec extends \PhpSpec\ObjectBehavior
{
    function it_contains_any_of()
    {
        $this->getArray()->shouldContainAnyOf(1, 2);
    }
}
    """

      And the class file "src/ContainAnyOf1.php" contains:
    """
<?php

class ContainAnyOf1
{
    public function getArray()
    {
        return [1, 2];
    }
}
    """

     When I run phpspec
     Then the suite should pass

  Scenario: The containAnyOf matcher does not make a positive match for invalid subject
      Given the spec file "spec/JamesHalsall/PhpSpecContainsMatchers/ContainAnyOf2Spec.php" contains:
    """
<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers;

class ContainAnyOf2Spec extends \PhpSpec\ObjectBehavior
{
    function it_contains_any_of()
    {
        $this->getArray()->shouldContainAnyOf(3, 4);
    }
}
    """

      And the class file "src/ContainAnyOf2.php" contains:
    """
<?php

namespace JamesHalsall\PhpSpecContainsMatchers;

class ContainAnyOf2
{
    public function getArray()
    {
        return [1, 2];
    }
}
    """

      When I run phpspec
      Then the suite should not pass

  Scenario: The containAnyOf matcher makes a negative match for invalid subject
    Given the spec file "spec/JamesHalsall/PhpSpecContainsMatchers/ContainAnyOf3Spec.php" contains:
    """
<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers;

class ContainAnyOf3Spec extends \PhpSpec\ObjectBehavior
{
    function it_contains_any_of()
    {
        $this->getArray()->shouldNotContainAnyOf(3, 4);
    }
}
    """

    And the class file "src/ContainAnyOf3.php" contains:
    """
<?php

namespace JamesHalsall\PhpSpecContainsMatchers;

class ContainAnyOf3
{
    public function getArray()
    {
        return [1, 2];
    }
}
    """

    When I run phpspec
    Then the suite should pass

  Scenario: The containAnyOf matcher does not make a negative match for valid subject
    Given the spec file "spec/JamesHalsall/PhpSpecContainsMatchers/ContainAnyOf4Spec.php" contains:
    """
<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers;

class ContainAnyOf4Spec extends \PhpSpec\ObjectBehavior
{
    function it_contains_any_of()
    {
        $this->getArray()->shouldNotContainAnyOf(2, 3);
    }
}
    """

    And the class file "src/ContainAnyOf4.php" contains:
    """
<?php

namespace JamesHalsall\PhpSpecContainsMatchers;

class ContainAnyOf4
{
    public function getArray()
    {
        return [1, 2];
    }
}
    """

    When I run phpspec
    Then the suite should not pass
