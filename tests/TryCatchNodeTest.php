<?php

namespace Pharborist;

use PHPUnit\Framework\TestCase;

class TryCatchNodeTest extends TestCase {
  public function testCatches() {
    /** @var \Pharborist\Exceptions\TryCatchNode $tryCatch */
    $tryCatch = Parser::parseSnippet('try { foo(); } catch (\InvalidArgumentException $e) {}');
    $this->assertTrue($tryCatch->catches('\InvalidArgumentException'));
    $this->assertFalse($tryCatch->catches('\DomainException'));
  }
}
