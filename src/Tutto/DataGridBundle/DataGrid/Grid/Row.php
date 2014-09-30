<?php

namespace Tutto\DataGridBundle\DataGrid\Grid;

use Tutto\DataGridBundle\DataGrid\Grid\Column\Event\Event;
use IteratorAggregate;
use ArrayIterator;
use ArrayAccess;
use Countable;
use Traversable;

/**
 * Class Row
 * @package Tutto\DataGridBundle\DataGrid\Grid
 */
class Row implements IteratorAggregate, ArrayAccess, Countable {
    /**
     * @var Event[]
     */
    protected $events = [];

    /**
     * @param Event[] $events
     */
    public function __construct(array $events = []) {
        $this->setEvents($events);
    }

    /**
     * @param Event $event
     */
    public function addEvent(Event $event) {
        $this->events[] = $event;
    }

    /**
     * @param int $index
     * @param Event $event
     */
    public function setEvent($index, Event $event) {
        $this->events[$index] = $event;
    }

    /**
     * @param int $index
     * @return bool
     */
    public function removeEvent($index) {
        if ($this->hasEvent($index)) {
            unset($this->events[$index]);
            return true;
        }

        return false;
    }

    /**
     * @param int $index
     * @return null|Event
     */
    public function getEvent($index) {
        return $this->hasEvent($index) ? $this->events[$index] : null;
    }

    /**
     * @param int $index
     * @return bool
     */
    public function hasEvent($index) {
        return isset($this->events[$index]);
    }

    /**
     * @return void
     */
    public function clearEvents() {
        $this->events = [];
    }

    /**
     * @param Event[] $events
     */
    public function setEvents(array $events) {
        $this->clearEvents();
        foreach ($events as $event) {
            $this->addEvent($event);
        }
    }

    /**
     * @return Event[]
     */
    public function getEvents() {
        return $this->events;
    }

    /**
     * @return Traversable
     */
    public function getIterator() {
        return new ArrayIterator($this->getEvents());
    }

    /**
     * @param mixed $offset
     * @return boolean
     */
    public function offsetExists($offset) {
        return $this->hasEvent($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset) {
        return $this->getEvent($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value) {
        if (!isset($offset)) {
            $this->addEvent($value);
        }
        $this->setEvent($offset, $value);
    }

    /**
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset) {
        $this->removeEvent($offset);
    }

    /**
     * @return int
     */
    public function count() {
        return count($this->getEvents());
    }
}