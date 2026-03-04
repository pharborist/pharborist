<?php

namespace Pharborist;

use Pharborist\ControlStructures\ReturnStatementNode;
use Pharborist\Types\TrueNode;
use PHPUnit\Framework\TestCase;

class ReturnStatementNodeTest extends TestCase {
  public function testCreate() {
    $ret = ReturnStatementNode::create(TrueNode::create());
    $this->assertEquals('return TRUE;', $ret->getText());
    $this->assertInstanceOf('\Pharborist\Types\TrueNode', $ret->getExpression());
  }
}
