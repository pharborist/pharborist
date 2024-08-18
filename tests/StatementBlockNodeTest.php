<?php
namespace Pharborist;

use PHPUnit\Framework\TestCase;

class StatementBlockNodeTest extends TestCase {
  public function testAppendStatement() {
    /** @var \Pharborist\ControlStructures\IfNode $ifNode */
    $ifNode = Parser::parseSnippet('if (TRUE) { hello(); }');
    /** @var StatementBlockNode $statementBlock */
    $statementBlock = $ifNode->getThen();
    $this->assertInstanceOf('\Pharborist\StatementBlockNode', $statementBlock);
    $this->assertEquals('{ hello(); }', $statementBlock->getText());
    $statementBlock->appendStatement(Parser::parseSnippet('world();'));
    $this->assertEquals('{ hello(); world();}', $statementBlock->getText());
  }
}
