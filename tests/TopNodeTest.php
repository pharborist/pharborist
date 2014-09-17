<?php

namespace Pharborist;

class TopNodeTest extends \PHPUnit_Framework_TestCase {
  public function testCreate() {
    $doc = TopNode::create();
    $this->assertEquals("<?php\n", $doc->getText());

    $doc = TopNode::create('Pharborist');
    $this->assertEquals("<?php\n\nnamespace Pharborist;\n", $doc->getText());

    $ns = $doc->children(Filter::isInstanceOf('\Pharborist\NamespaceNode'))[0];
    $this->assertEquals('\Pharborist', $ns->getName()->getAbsolutePath());
  }
}
