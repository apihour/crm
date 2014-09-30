<?php

namespace Tutto\CommonBundle\Form\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class IgnoreNonSubmittedFieldSubscriber
 * @package Tutto\CommonBundle\Form\Subscriber
 */
class IgnoreNonSubmittedFieldSubscriber implements EventSubscriberInterface {
    /**
     * @return array
     */
    public static function getSubscribedEvents() {
        return array(FormEvents::PRE_SUBMIT => 'preSubmit');
    }

    public function preSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();
        foreach ($form->all() as $name => $child) {
            if (!isset($data[$name])) {
                $form->remove($name);
            }
        }
    }
}