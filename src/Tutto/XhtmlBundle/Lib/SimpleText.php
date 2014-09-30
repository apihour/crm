<?php

namespace Tutto\XhtmlBundle\Lib;

/**
 * Class SimpleText
 * @package Tutto\XhtmlBundle\Lib
 */
class SimpleText extends AbstractTag {
    /**
     * @var string
     */
    protected $text = '';

    /**
     * @param string $text
     * @param array $children
     */
    public function __construct($text = '', array $children = []) {
        $this->setText($text);
        $this->setChildren($children);
    }

    /**
     * @param string $text
     */
    public function setText($text) {
        $this->text = (string) $text;
    }

    /**
     * @return string
     */
    public function getText() {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getAliasName() {
        return 'simple_text';
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->text;
    }
}