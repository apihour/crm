<?php

namespace Tutto\CommonBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Tutto\CommonBundle\Form\AbstractFormType;
use Tutto\CommonBundle\Tools\Status;

/**
 * Class StatusType
 * @package Tutto\CommonBundle\Form\Type
 */
class StatusType extends AbstractFormType {
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'choices' => [
                Status::ENABLED  => 'status.enabled',
                Status::DISABLED => 'status.disabled'
            ]
        ]);
    }

    /**
     * @return string
     */
    public function getParent() {
        return 'choice';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'tutto_common_status';
    }
}