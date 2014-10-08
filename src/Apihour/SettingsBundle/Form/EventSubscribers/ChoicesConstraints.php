<?php

namespace Apihour\SettingsBundle\Form\EventSubscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class ChoicesConstraints
 * @package Apihour\SettingsBundle\Form\EventSubscribers
 */
class ChoicesConstraints implements EventSubscriberInterface {
    public static function getSubscribedEvents() {
        return [
            FormEvents::PRE_SET_DATA => 'preSetDataAndPreSubmit',
            FormEvents::PRE_SUBMIT   => 'preSetDataAndPreSubmit'
        ];
    }

    /**
     * @param FormEvent $event
     */
    public function preSetDataAndPreSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        $collectionOptions = [
            'mapped'       => true,
            'required'     => false,
            'prototype'    => true,
            'type'         => 'text',
            'allow_add'    => true,
            'allow_delete' => true
        ];

        var_dump($form->getParent()->get('type')->getData());

        if ($form->getParent()->get('type')->getData() !== 'choice') {
            $form->add(
                'choices',
                'collection',
                array_merge_recursive(
                    $collectionOptions,
                    ['mapped' => false]
                )
            );
        } else {
            $form->add(
                'choices',
                'collection',
                $collectionOptions
            );
        }
    }
}