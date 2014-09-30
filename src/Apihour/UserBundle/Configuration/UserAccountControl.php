<?php

namespace Apihour\UserBundle\Configuration;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationAnnotation;

/**
 * Class UserAccountControl
 * @package Apihour\UserBundle\Configuration
 *
 * @Annotation
 */
class UserAccountControl extends ConfigurationAnnotation {
    protected $controls = array();

    /**
     * @return array
     */
    public function getControls() {
        return $this->controls;
    }

    /**
     * @param array $controls
     */
    public function setControls($controls) {
        $this->controls = $controls;
    }

    /**
     * @return string
     */
    public function getAliasName() {
        return 'apihour_user_control';
    }

    /**
     * @return bool
     */
    public function allowArray() {
        return true;
    }
}