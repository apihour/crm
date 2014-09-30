<?php

namespace Tutto\CommonBundle\Form\DataTransformer;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Intl\Intl;
use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;

/**
 * Class CountryTransformer
 * @package Tutto\CommonBundle\Form\DataTransformer
 */
class CountryTransformer extends AbstractContainerAware implements DataTransformerInterface {
    /**
     * @var null|string
     */
    protected $dataAccess = null;

    /**
     * @var null
     */
    protected $dataAccessForName = "name";

    /**
     * @param string|null $dataAccess
     */
    public function __construct(ContainerInterface $container, $dataAccess = null, $dataAccessForName = "name") {
        parent::__construct($container);
        $this->dataAccess = $dataAccess;
        $this->dataAccessForName = $dataAccessForName;
    }

    /**
     * @param mixed $value
     * @return array|mixed|null
     */
    public function transform($value) {
        if(!empty($value)) {
            $locale = strtoupper($this->getContainer()->get('request')->getLocale());

            if (isset($this->dataAccess)) {
                return [
                    $this->dataAccess => $value,
                    $this->dataAccessForName => Intl::getRegionBundle()->getCountryName(strtoupper($value), $locale)
                ];
            } else {
                return Intl::getRegionBundle()->getCountryName(strtoupper($value), $locale);
            }
        }

        return null;
    }

    /**
     * @param mixed $value
     * @return mixed|void
     */
    public function reverseTransform($value) {
        if(empty($value)) {
            return null;
        } elseif($this->dataAccess === null) {
            return $value;
        } else {
            if(isset($value[$this->dataAccess])) {
                return $value[$this->dataAccess];
            } else {
//                throw new TransformationFailedException("Can not transform. Data access to: '{$this->dataAccess}' was not imposible.");
            }
        }
    }
}