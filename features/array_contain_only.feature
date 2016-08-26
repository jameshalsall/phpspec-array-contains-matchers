Feature: Using the containOnly matcher
  In order to use the containOnly matcher
  I need to enabled the PhpSpecContainsMatchers extension

  Background:
    Given the config file contains:
    """
    extensions:
      JamesHalsall\PhpSpecContainsMatchers\Extension: ~
    """

  Scenario: The containOnly matcher makes a positive match for valid subject
    Given the spec file "spec/ContainOnly1Spec.php" contains:
    """
<?php

namespace spec;

class ContainOnly1Spec extends \PhpSpec\ObjectBehavior
{
    function it_contains_only()
    {
        $this->getArray()->shouldContainOnly(1, 2);
    }
}
    """

    And the class file "src/ContainOnly1.php" contains:
    """
<?php

class ContainOnly1
{
    public function getArray()
    {
        return [1, 2];
    }
}
    """

    When I run phpspec
    Then the suite should pass

  Scenario: The containOnly matcher does not make a positive match for invalid subject
    Given the spec file "spec/JamesHalsall/PhpSpecContainsMatchers/ContainOnly2Spec.php" contains:
    """
<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers;

class ContainOnly2Spec extends \PhpSpec\ObjectBehavior
{
    function it_contains_only()
    {
        $this->getArray()->shouldContainOnly(3, 4);
    }
}
    """

    And the class file "src/ContainOnly2.php" contains:
    """
<?php

namespace JamesHalsall\PhpSpecContainsMatchers;

class ContainOnly2
{
    public function getArray()
    {
        return [1, 2];
    }
}
    """

    When I run phpspec
    Then the suite should not pass

  Scenario: The containOnly matcher makes a negative match for invalid subject
    Given the spec file "spec/JamesHalsall/PhpSpecContainsMatchers/ContainOnly3Spec.php" contains:
    """
<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers;

class ContainOnly3Spec extends \PhpSpec\ObjectBehavior
{
    function it_contains_any_of()
    {
        $this->getArray()->shouldNotContainOnly(3, 4);
    }
}
    """

    And the class file "src/ContainOnly3.php" contains:
    """
<?php

namespace JamesHalsall\PhpSpecContainsMatchers;

class ContainOnly3
{
    public function getArray()
    {
        return [1, 2];
    }
}
    """

    When I run phpspec
    Then the suite should pass

  Scenario: The containOnly matcher does not make a negative match for valid subject
    Given the spec file "spec/JamesHalsall/PhpSpecContainsMatchers/ContainOnly4Spec.php" contains:
    """
<?php

namespace spec\JamesHalsall\PhpSpecContainsMatchers;

class ContainOnly4Spec extends \PhpSpec\ObjectBehavior
{
    function it_contains_any_of()
    {
        $this->getArray()->shouldNotContainOnly(1, 2);
    }
}
    """

    And the class file "src/ContainOnly4.php" contains:
    """
<?php

namespace JamesHalsall\PhpSpecContainsMatchers;

class ContainOnly4
{
    public function getArray()
    {
        return [1, 2];
    }
}
    """

    When I run phpspec
    Then the suite should not pass
