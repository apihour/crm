<?php

namespace Tutto\SecurityBundle\Configuration;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationAnnotation;

/**
 * Class Authorization
 * @package Tutto\SecurityBundle\Configuration
 *
 * @Annotation
 */
class Authorization extends ConfigurationAnnotation {
    /**
     * @var array
     */
    protected $roles = array();

    /**
     * @var bool
     */
    protected $omit = false;

    /**
     * @param array $values
     */
    public function __construct(array $values) {
        if (isset($values['value']) && is_array($values['value'])) {
            $values['roles'] = $values['value'];
            unset($values['value']);
        }

        parent::__construct($values);
    }

    /**
     * @return boolean
     */
    public function isOmit() {
        return $this->omit;
    }

    /**
     * @param boolean $omit
     */
    public function setOmit($omit) {
        $this->omit = $omit;
    }

    /**
     * @return array
     */
    public function getRoles() {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles) {
        $this->roles = $roles;
    }

    /**
     * Returns the alias name for an annotated configuration.
     *
     * @return string
     */
    public function getAliasName() {
        return 'authorization';
    }

    /**
     * Returns whether multiple annotations of this type are allowed
     *
     * @return bool
     */
    public function allowArray() {
        return true;
    }
}