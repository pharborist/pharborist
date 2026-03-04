<?php
namespace Pharborist;

use Pharborist\Namespaces\NamespaceNode;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use phpDocumentor\Reflection\Types\Context;

/**
 * A doc comment.
 */
class DocCommentNode extends CommentNode {
  /**
   * Parsed doc block.
   *
   * @var DocBlock
   */
  private $docBlock;

  /**
   * Creates a PHPDoc comment.
   *
   * @param string $comment
   *   The comment body without asterisks, but formatted into lines.
   *
   * @return DocCommentNode
   */
  public static function create($comment) {
    $comment = trim($comment);
    $lines = array_map('trim', explode("\n", $comment));
    $text = "/**\n";
    foreach ($lines as $i => $line) {
      $text .= ' * ' . $line . "\n";
    }
    $text .= ' */';
    return new DocCommentNode(T_DOC_COMMENT, $text);
  }

  /**
   * Set indent for document comment.
   *
   * @param string $indent
   *   Whitespace to use as indent.
   * @return $this
   */
  public function setIndent($indent) {
    $lines = explode("\n", $this->text);
    if (count($lines) === 1) {
      return $this;
    }
    $comment = '';
    $last_index = count($lines) - 1;
    foreach ($lines as $i => $line) {
      if ($i === 0) {
        $comment .= trim($line) . "\n";
      }
      elseif ($i === $last_index) {
        $comment .= $indent . ' ' . trim($line);
      }
      else {
        $comment .= $indent . ' ' . trim($line) . "\n";
      }
    }
    $this->setText($comment);
    return $this;
  }

  public function setText($text) {
    parent::setText($text);
    $this->docBlock = NULL;
  }

  /**
   * Return the parsed doc comment.
   *
   * @return DocBlock
   *   Parsed doc comment.
   */
  public function getDocBlock() {
    if ($this->docBlock === NULL) {
      $namespace = '\\';
      $aliases = array();
      /** @var NamespaceNode $namespace_node */
      $namespace_node = $this->closest(Filter::isInstanceOf('\Pharborist\Namespaces\NamespaceNode'));
      if ($namespace_node !== NULL) {
        $namespace = $namespace_node->getName() ? $namespace_node->getName()->getAbsolutePath() : '';
        $aliases = $namespace_node->getClassAliases();
      } else {
        /** @var RootNode $root_node */
        $root_node = $this->closest(Filter::isInstanceOf('\Pharborist\RootNode'));
        if ($root_node !== NULL) {
          $aliases = $root_node->getClassAliases();
        }
      }
      $context = new Context($namespace, $aliases);
      $factory = DocBlockFactory::createInstance();
      $this->docBlock = $factory->create($this->text, $context);
    }
    return $this->docBlock;
  }

  /**
   * Get the opening line or also known as short description.
   *
   * @return string
   *   Short description.
   */
  public function getShortDescription() {
    return $this->getDocBlock()->getSummary();
  }

  /**
   * Get the full description or also known as long description.
   *
   * @return string
   *   Long description.
   */
  public function getLongDescription() {
    return (string) $this->getDocBlock()->getDescription();
  }

  /**
   * Get the return tag.
   *
   * @return Return_|false
   *   Return tag.
   */
  public function getReturn() {
    $return_tags = $this->getDocBlock()->getTagsByName('return');
    return end($return_tags);
  }

  /**
   * Get the parameter tags.
   *
   * @return Param[]
   *   Array of parameter tags.
   */
  public function getParameters() {
    return $this->getDocBlock()->getTagsByName('param');
  }

  /**
   * Get the parameter tags by name.
   *
   * @return Param[]
   *   Associative array of parameter names to parameters.
   */
  public function getParametersByName() {
    $param_tags = $this->getDocBlock()->getTagsByName('param');
    $parameters = array();
    /** @var Param $param_tag */
    foreach ($param_tags as $param_tag) {
      $name = ltrim($param_tag->getVariableName(), '$');
      $parameters[$name] = $param_tag;
    }
    return $parameters;
  }

  /**
   * Get a parameter tag.
   *
   * @param $parameterName
   *   Name of parameter to get tag for.
   *
   * @return null|Param
   *   The tag for parameter.
   */
  public function getParameter($parameterName) {
    $parameterName = ltrim($parameterName, '$');
    $param_tags = $this->getDocBlock()->getTagsByName('param');
    /** @var Param $param_tag */
    foreach ($param_tags as $param_tag) {
      if (ltrim($param_tag->getVariableName(), '$') === $parameterName) {
        return $param_tag;
      }
    }
    return NULL;
  }
}
