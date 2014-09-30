<?php

namespace Tutto\SecurityBundle\Util;

/**
 * Interface SuspendedInterface
 * @package Tutto\SecurityBundle\Util
 */
interface SuspendedInterface {
    /**
     * Suspend object.
     *
     * @return void
     */
    public function suspend();

    /**
     * Activate object.
     *
     * @return void
     */
    public function activate();

    /**
     * Check if object is suspended or activated.
     *
     * @return boolean
     */
    public function isSuspend();
} 