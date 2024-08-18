<?php
namespace Pharborist;

use PHPUnit\Framework\TestCase;

class ClassMethodNodeTest extends TestCase {
  public function testGetFullyQualifiedName() {
    /** @var \Pharborist\Objects\ClassNode $class */
    $class = Parser::parseSnippet('class Foo { public function baz() {} }');
    /** @var \Pharborist\Objects\ClassMethodNode $method */
    $method = $class->getMethod('baz');
    $this->assertEquals('\Foo::baz', $method->getFullyQualifiedName());
  }

  public function testSetName() {
    /** @var \Pharborist\Objects\ClassNode $class */
    $class = Parser::parseSnippet('class Foo { public function baz() {} }');
    /** @var \Pharborist\Objects\ClassMethodNode $method */
    $method = $class->getMethod('baz');
    $method->setName('bar');
    $this->assertEquals('bar', $method->getName()->getText());
    $this->assertEquals('public function bar() {}', $method->getText());
  }
}
