<?php

namespace Tutto\CommonBundle\Configuration;

/**
 * Class Menu
 * @package Tutto\CommonBundle\Configuration
 *
 * @Annotation
 */
class Menu extends AbstractConfiguration {
    const DEFAULT_MENU = 'defaultMenu';
    const MAIN_MENU    = 'mainMenu';

    /**
     * @var string
     */
    protected $menu = self::DEFAULT_MENU;

    /**
     * @var string
     */
    protected $currentItem;

    /**
     * @return mixed
     */
    public function getMenu() {
        return $this->menu;
    }

    /**
     * @param mixed $menu
     */
    public function setMenu($menu) {
        $this->menu = $menu;
    }

    /**
     * @return mixed
     */
    public function getCurrentItem() {
        return $this->currentItem;
    }

    /**
     * @param mixed $currentItem
     */
    public function setCurrentItem($currentItem) {
        $this->currentItem = $currentItem;
    }
} 