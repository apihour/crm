<?php

namespace Apihour\UserBundle\Configuration;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationAnnotation;

use LogicException;

/**
 * Class AccountPrivilege
 * @package Apihour\UserBundle\Configuration
 *
 * @Annotation
 */
class AccountPrivilege extends ConfigurationAnnotation {
    /**
     * @var array
     */
    protected $control;

    /**
     * @param array $parameters
     * @throws LogicException
     */
    public function __construct(array $parameters = []) {
        if (isset($parameters['value'])) {
            $parameters['control'] = $parameters['value'];
            unset($parameters['value']);
        }

        if (is_array($parameters['control'])) {
            throw new LogicException("exceptions:controlsCanNotBeArray");
        }

        parent::__construct($parameters);
    }

    /**
     * @return array
     */
    public function getControl() {
        return $this->control;
    }

    /**
     * @param array $control
     */
    public function setControl($control) {
        $this->control = $control;
    }

    /**
     * Returns the alias name for an annotated configuration.
     *
     * @return string
     */
    public function getAliasName() {
        return 'account_privilege';
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