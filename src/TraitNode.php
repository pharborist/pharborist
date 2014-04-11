<?php
namespace Pharborist;

/**
 * A trait declaration.
 */
class TraitNode extends StatementNode {
  protected $properties = array(
    'docComment' => NULL,
    'name' => NULL,
    'extends' => NULL,
    'implements' => array(),
    'statements' => NULL,
  );

  /**
   * @return DocCommentNode
   */
  public function getDocComment() {
    return $this->properties['docComment'];
  }

  /**
   * @return TokenNode
   */
  public function getName() {
    return $this->properties['name'];
  }

  /**
   * @return NamespacePathNode
   */
  public function getExtends() {
    return $this->properties['extends'];
  }

  /**
   * @return NamespacePathNode[]
   */
  public function getImplements() {
    return $this->properties['implements'];
  }

  /**
   * @return (ClassMemberListNode|ClassMethodNode|ConstantDeclarationNode|TraitUseNode)[]
   */
  public function getStatements() {
    return $this->properties['statements'];
  }
}
