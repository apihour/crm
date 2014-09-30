<?php

namespace Apihour\FileBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\FormInterface;

use Tutto\FileBundle\Form\Type\FileType as BaseFileType;
use Apihour\FileBundle\Entity\File;

/**
 * Class FileType
 * @package Apihour\FileBundle\Form\Type
 */
class FileType extends BaseFileType {
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'cascade_validation' => true,
            'data_class' => File::class,
            'empty_data' => function (FormInterface $form) {
                if (($uploadedFile = $form->get('file')->getData()) instanceof UploadedFile) {
                    return new File($uploadedFile);
                }
            }
        ]);
    }

} 