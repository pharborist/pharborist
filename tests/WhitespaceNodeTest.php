<?php
namespace Pharborist;

use PHPUnit\Framework\TestCase;

class WhitespaceNodeTest extends TestCase {
  public function testNewlineCount() {
    $node = Token::whitespace(" \n  \n\n \n  ");
    $this->assertEquals(4, $node->getNewlineCount());
  }
}
