<?php
namespace Pharborist;

use PHPUnit\Framework\TestCase;

class IdentifierNameTraitTest extends TestCase {
  public function testId() {
    $snippet = <<<'EOF'
namespace Test {
  function hello_world() {
    echo 'hello world!', PHP_EOL;
  }
}
EOF;
    /** @var \Pharborist\Namespaces\NamespaceNode $namespace_node */
    $namespace_node = Parser::parseSnippet($snippet);
    /** @var \Pharborist\Functions\FunctionDeclarationNode $function */
    $function = $namespace_node->getBody()->children(Filter::isFunction('hello_world'))[0];
    $this->assertEquals('hello_world', $function->getName()->getText());
    $this->assertSame($namespace_node, $function->getNamespace());
    $this->assertTrue($function->inNamespace($namespace_node));
    $this->assertTrue($function->inNamespace('\Test'));
    $this->assertFalse($function->inNamespace('\Dummy\Test'));
  }

  public function testInvalid() {
    $this->expectException(\InvalidArgumentException::class);
    $snippet = <<<'EOF'
namespace Test {
  function hello_world() {
    echo 'hello world!', PHP_EOL;
  }
}
EOF;
    /** @var \Pharborist\Namespaces\NamespaceNode $namespace_node */
    $namespace_node = Parser::parseSnippet($snippet);
    /** @var \Pharborist\Functions\FunctionDeclarationNode $function */
    $function = $namespace_node->getBody()->children(Filter::isFunction('hello_world'))[0];
    $this->assertTrue($function->inNamespace(new \stdClass()));
  }
}
