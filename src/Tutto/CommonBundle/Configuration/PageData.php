<?php

namespace Tutto\CommonBundle\Configuration;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationAnnotation;

/**
 * Class PageData
 * @package Tutto\CommonBundle\Configuration
 *
 * @Annotation
 */
class PageData extends ConfigurationAnnotation {
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param array $values
     */
    public function __construct(array $values) {
        parent::__construct(['data' => $values]);
    }

    /**
     * @return array
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getAliasName() {
        return 'page_data';
    }

    /**
     * @return bool
     */
    public function allowArray() {
        return true;
    }
}