<?php
namespace Pharborist;

use Pharborist\Operators\BinaryOperationNode;
use PHPUnit\Framework\TestCase;

class BinaryOperationNodeTest extends TestCase {
  /** @var BinaryOperationNode $op */
  private $op;

  public function setup(): void {
    $this->op = Parser::parseSnippet('$doAliensExist = TRUE;')->firstChild();
  }

  public function testInstanceOf() {
    $this->assertInstanceOf('Pharborist\Operators\AssignNode', $this->op);
  }

  public function testGetLeftOperand() {
    $this->assertInstanceOf('Pharborist\Variables\VariableNode', $this->op->getLeftOperand());
    $this->assertEquals('doAliensExist', $this->op->getLeftOperand()->getName());
  }

  public function testGetOperator() {
    $this->assertInstanceOf('Pharborist\TokenNode', $this->op->getOperator());
    $this->assertEquals('=', $this->op->getOperator()->getText());
  }

  public function testGetRightOperand() {
    $this->assertInstanceOf('Pharborist\Constants\ConstantNode', $this->op->getRightOperand());
    $this->assertEquals('TRUE', $this->op->getRightOperand()->getText());
  }
}
