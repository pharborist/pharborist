<?php
namespace Pharborist;

use PHPUnit\Framework\TestCase;

class FunctionCallNodeTest extends TestCase {
  public function testName() {
    /** @var \Pharborist\Functions\FunctionCallNode $function_call */
    $function_call = Parser::parseExpression('test()');
    $this->assertEquals('test', $function_call->getName()->getText());
    $function_call->setName('hello');
    $this->assertEquals('hello', $function_call->getName()->getText());
  }
}
