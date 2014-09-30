<?php

namespace Tutto\XhtmlBundle\Lib;

/**
 * Class AbstractTag
 * @package Tutto\XhtmlBundle\Lib
 */
abstract class AbstractTag implements TagInterface {
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * @var AbstractTag
     */
    protected $parent;

    /**
     * @var TagInterface[]
     */
    protected $children = [];

    /**
     * @param string $name
     * @param array $attributes
     * @param array $children
     */
    public function __construct($name, array $attributes = array(), array $children = []) {
        $this->name = (string) $name;
        $this->setAttributes($attributes);
        $this->setChildren($children);
    }

    /**
     * @return array
     */
    public function getAttributes() {
        return $this->attributes;
    }

    /**
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    public function getAttribute($name, $default = null) {
        if($this->hasAttribute($name)) {
            return $this->attributes[$name];
        }

        return $default;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes) {
        $this->attributes = $attributes;
    }

    /**
     * @param $name
     * @param $value
     */
    public function setAttribute($name, $value) {
        $this->attributes[$name] = $value;
    }

    /**
     * @param $name
     * @param $value
     */
    public function addAttribute($name, $value) {
        if($this->hasAttribute($name)) {
            $this->attributes[$name][] = $value;
        } else {
            $this->setAttribute($name, $value);
        }
    }

    /**
     * @param null|string $name
     */
    public function clearAttributes($name = null) {
        if($name !== null) {
            if($this->hasAttribute($name)) {
                unset($this->attributes[$name]);
            }
        } else {
            $this->attributes = [];
        }
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasAttribute($name) {
        return isset($this->attributes[$name]);
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return AbstractTag
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent(TagInterface $parent) {
        $this->parent = $parent;
    }

    /**
     * @param TagInterface $tag
     */
    public function addChild(TagInterface $tag) {
        if($tag instanceof AbstractTag) {
            $tag->setParent($tag);
        }

        $this->children[] = $tag;
    }

    /**
     * @param TagInterface[] $tags
     */
    public function setChildren(array $tags) {
        $this->clearChildren();
        $this->addChildren($tags);
    }

    /**
     * @param TagInterface[] $tags
     */
    public function addChildren(array $tags) {
        foreach ($tags as $tag) {
            $this->addChild($tag);
        }
    }

    /**
     * @return void
     */
    public function clearChildren() {
        $this->children = array();
    }

    /**
     * @return TagInterface[]
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * @return bool
     */
    public function hasChildren() {
        return !empty($this->getChildren());
    }
} 