<?php

namespace Tutto\CommonBundle\Configuration;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationAnnotation;

/**
 * Class Metadata
 * @package Tutto\CommonBundle\Configuration
 *
 * @Annotation
 */
class Metadata extends ConfigurationAnnotation {
    const DEFAULT_TITLE       = 'System CRM';
    const DEFAULT_DESCRITPION = 'System CRM';
    const DEFAULT_KEYWORDS    = '';

    /**
     * @var string
     */
    protected $title = self::DEFAULT_TITLE;

    /**
     * @var string
     */
    protected $description = self::DEFAULT_DESCRITPION;

    /**
     * @var string
     */
    protected $keywords = self::DEFAULT_KEYWORDS;

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getKeywords() {
        return $this->keywords;
    }

    /**
     * @param mixed $keywords
     */
    public function setKeywords($keywords) {
        $this->keywords = $keywords;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Returns the alias name for an annotated configuration.
     *
     * @return string
     */
    public function getAliasName() {
        return 'metadata';
    }

    /**
     * Returns whether multiple annotations of this type are allowed
     *
     * @return bool
     */
    public function allowArray() {
        return false;
    }
}