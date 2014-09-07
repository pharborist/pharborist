<?php
namespace Pharborist;

/**
 * Trait for nodes that have parameters. For example, function declarations.
 */
trait ParameterTrait {
  /**
   * @var CommaListNode
   */
  protected $parameters;

  /**
   * @return CommaListNode
   */
  public function getParameterList() {
    return $this->parameters;
  }

  /**
   * @return ParameterNode[]
   */
  public function getParameters() {
    return $this->parameters->getItems();
  }

  /**
   * @return string[]
   */
  public function getParameterNames() {
    return array_map(function(ParameterNode $parameter) {
      return substr($parameter->getName(), 1);
    }, $this->getParameters());
  }

  /**
   * @param ParameterNode $parameter
   * @return $this
   */
  public function prependParameter(ParameterNode $parameter) {
    $this->parameters->prependItem($parameter);
    return $this;
  }

  /**
   * @param ParameterNode $parameter
   * @return $this
   */
  public function appendParameter(ParameterNode $parameter) {
    $this->parameters->appendItem($parameter);
    return $this;
  }

  /**
   * Insert parameter before parameter at index.
   *
   * @param ParameterNode $parameter
   * @param int $index
   * @throws \OutOfBoundsException
   *   Index out of bounds.
   * @return $this
   */
  public function insertParameter(ParameterNode $parameter, $index) {
    $this->parameters->insertItem($parameter, $index);
    return $this;
  }

  /**
   * Remove all parameters.
   *
   * @return $this
   */
  public function clearParameters() {
    $this->parameters->clear();
    return $this;
  }

  /**
   * Gets a parameter by name or index.
   *
   * @param mixed $key
   *  The parameter's name (without leading $) or position in the
   *  parameter list.
   *
   * @return ParameterNode
   *
   * @throws \InvalidArgumentException if the key is not a string or integer.
   */
  public function getParameter($key) {
    if (is_string($key)) {
      return $this->getParameterByName($key);
    }
    elseif (is_integer($key)) {
      return $this->getParameterAtIndex($key);
    }
    else {
      throw new \InvalidArgumentException("Illegal parameter index {$key}.");
    }
  }

  /**
   * Gets a parameter by its position in the parameter list.
   *
   * @param integer $index
   *
   * @return ParameterNode
   */
  public function getParameterAtIndex($index) {
    return $this->getParameterList()->getItem($index);
  }

  /**
   * Gets a parameter by its name.
   *
   * @param string $name
   *  The parameter name without leading $.
   *
   * @return ParameterNode
   *
   * @throws \UnexpectedValueException if the named parameter doesn't exist.
   */
  public function getParameterByName($name) {
    foreach ($this->getParameters() as $parameter) {
      if ($parameter->getName() === $name) {
        return $parameter;
      }
    }
    throw new \UnexpectedValueException("Parameter {$name} does not exist.");
  }

  /**
   * Checks if the function/method has a certain parameter.
   *
   * @param mixed $parameter
   *  Either the parameter name (with or without the $), or a ParameterNode.
   * @param string $type
   *  Optional type hint to check as well.
   *
   * @return boolean
   *
   * @throws \InvalidArgumentException if $parameter is neither a string or
   * a ParameterNode.
   */
  public function hasParameter($parameter, $type = NULL) {
    if ($parameter instanceof ParameterNode) {
      $exists = in_array($parameter, $this->getParameters(), TRUE);
    }
    elseif (is_string($parameter)) {
      $exists = in_array($parameter, $this->getParameterNames());
    }
    else {
      throw new \InvalidArgumentException();
    }

    if ($exists) {
      return $type ? $this->getParameterByName($parameter)->getTypeHint()->getText() === $type : FALSE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Checks if the function/method has a specific required parameter.
   *
   * @param mixed $parameter
   *  Either the name of the parameter (with or without leading $), or a
   *  ParameterNode.
   * @param string $type
   *  Optional type hint to check.
   *
   * @return boolean
   */
  public function hasRequiredParameter($parameter, $type) {
    return $this->hasParameter($parameter, $type, TRUE) ? $this->getParameterByName($name)->isRequired() : FALSE;
  }

  /**
   * Checks if the function/method has a specific optional parameter.
   *
   * @param mixed $parameter
   *  Either the name of the parameter (with or without leading $), or a
   *  ParameterNode.
   * @param string $type
   *  Optional type hint to check.
   *
   * @return boolean
   */
  public function hasOptionalParameter($parameter, $type) {
    return $this->hasParameter($parameter, $type, FALSE) ? $this->getParameterByName($parameter)->isOptional() : FALSE;
  }

  /**
   * @return boolean
   */
  public function hasRequiredParameters() {
    return ($this->getRequiredParameters()->count() > 0);
  }

  /**
   * @return NodeCollection
   */
  public function getRequiredParameters() {
    return $this->parameters
      ->children(Filter::isInstanceOf('Pharborist\ParameterNode'))
      ->filter(function(ParameterNode $parameter) {
        $value = $parameter->getValue();
        return !isset($value);
      });
  }
  
  /**
   * @return NodeCollection
   */
  public function getOptionalParameters() {
    return $this->parameters
      ->children(Filter::isInstanceOf('Pharborist\ParameterNode'))
      ->filter(function(ParameterNode $parameter) {
        $value = $parameter->getValue();
        return isset($value);
      });
  }
}
