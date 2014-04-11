<?php
namespace Pharborist;

/**
 * A function declaration.
 */
class FunctionDeclarationNode extends StatementNode {
  protected $properties = array(
    'docComment' => NULL,
    'reference' => NULL,
    'name' => NULL,
    'parameters' => array(),
    'body' => NULL,
  );

  /**
   * @return DocCommentNode
   */
  public function getDocComment() {
    return $this->properties['docComment'];
  }

  /**
   * @return Node
   */
  public function getReference() {
    return $this->properties['reference'];
  }

  /**
   * @return Node
   */
  public function getName() {
    return $this->properties['name'];
  }

  /**
   * @return ParameterNode[]
   */
  public function getParameters() {
    return $this->properties['parameters'];
  }

  /**
   * @return Node
   */
  public function getBody() {
    return $this->properties['body'];
  }
}
