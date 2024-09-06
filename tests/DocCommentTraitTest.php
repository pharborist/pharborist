<?php
namespace Pharborist;

use Pharborist\Objects\ClassNode;
use PHPUnit\Framework\TestCase;

class DocCommentTraittest extends TestCase {

  public function testCreateDocComment() {
    $node = ClassNode::create('Foo');
    $node->setDocComment(DocCommentNode::create('Ni!'));
    $comment = $node->getDocComment();
    $this->assertInstanceOf('\Pharborist\DocCommentNode', $comment);
    $this->assertEquals('Ni!', $comment->getCommentText());
  }

  public function testChangeDocComment() {
    $node = ClassNode::create('Foo');
    $node->setDocComment(DocCommentNode::create('Ni!'));
    $node->setDocComment(DocCommentNode::create('Noo!'));
    $comment = $node->getDocComment();
    $this->assertInstanceOf('\Pharborist\DocCommentNode', $comment);
    $this->assertEquals('Noo!', $comment->getCommentText());
  }

}
