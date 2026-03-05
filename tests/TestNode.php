<?php
namespace Pharborist;

/**
 * Concrete Node subclass for testing.
 */
class TestNode extends Node {
  private string $text;

  public function __construct(string $text = '') {
    $this->text = $text;
  }

  public function getFilename() {
    return '';
  }

  public function getLineNumber() {
    return 0;
  }

  public function getNewlineCount() {
    return 0;
  }

  public function getColumnNumber() {
    return 0;
  }

  public function getByteOffset() {
    return 0;
  }

  public function getByteLength() {
    return strlen($this->text);
  }

  public function getText() {
    return $this->text;
  }
}
