<?php

namespace Pharborist;

use Pharborist\Variables\VariableNode;
use PHPUnit\Framework\TestCase;

class VariableNodeTest extends TestCase {
  public function testGetName() {
    $var = new VariableNode(T_VARIABLE, '$form');
    $this->assertEquals('form', $var->getName());
  }

  /**
   * @depends testGetName
   */
  public function testSetName() {
    $var = new VariableNode(T_VARIABLE, '$x');
    $var->setName('$y');
    $this->assertEquals('y', $var->getName());
    $var->setName('z');
    $this->assertEquals('z', $var->getName());
  }
}
