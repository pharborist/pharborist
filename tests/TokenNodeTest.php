<?php
namespace Pharborist;

use PHPUnit\Framework\TestCase;

class TokenNodeTest extends TestCase {
  public function testGetTypeName() {
    $id = new TokenNode(T_STRING, 'hello');
    $this->assertEquals('T_STRING', $id->getTypeName());

    $comma = new TokenNode(',', ',');
    $this->assertEquals(',', $comma->getTypeName());
  }
}
