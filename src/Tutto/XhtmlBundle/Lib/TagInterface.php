<?php

namespace Tutto\XhtmlBundle\Lib;

/**
 * Class TagInterface
 * @package Tutto\XhtmlBundle\Lib
 */
interface TagInterface {
    /**
     * @param TagInterface $tag
     * @return void
     */
    public function addChild(TagInterface $tag);

    /**
     * @return TagInterface[]
     */
    public function getChildren();

    /**
     * @param TagInterface $tag
     * @return void
     */
    public function setParent(TagInterface $tag);

    /**
     * @return TagInterface
     */
    public function getParent();

    /**
     * @param array $attributes
     * @return void
     */
    public function setAttributes(array $attributes);

    /**
     * @return array
     */
    public function getAttributes();

    /**
     * @param string $name
     * @param null|mixed $default
     * @return mixed
     */
    public function getAttribute($name, $default = null);

    /**
     * @param string $name
     * @return bool
     */
    public function hasAttribute($name);

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function addAttribute($name, $value);

    /**
     * @return void
     */
    public function clearAttributes();

    /**
     * @return string
     */
    public function getAliasName();
} 