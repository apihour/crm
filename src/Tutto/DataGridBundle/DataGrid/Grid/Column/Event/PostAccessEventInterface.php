<?php

namespace Tutto\DataGridBundle\DataGrid\Grid\Column\Event;

/**
 * Interface PostAccessEventInterface
 * @package Tutto\DataGridBundle\DataGrid\Grid\Column\Event
 */
interface PostAccessEventInterface {
    /**
     * @param Event $event
     * @return void
     */
    public function postAccess(Event $event);
} 