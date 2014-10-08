<?php

namespace Apihour\FrontendBundle\Form\Transformer;

use Apihour\FrontendBundle\Repository\CategoryRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Apihour\FrontendBundle\Entity\Category;

/**
 * Class CategorySelectableTransformer
 * @package Apihour\FrontendBundle\Form\Transformer
 */
class CategorySelectableTransformer implements DataTransformerInterface {
    /**
     * @var CategoryRepository
     */
    protected $repository;

    /**
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function transform($value) {
        if ($value !== null) {
            $this->repository->find($value->getId());
        } else {
            return null;
        }
    }

    /**
     * @param mixed $value
     * @return mixed|null
     */
    public function reverseTransform($value) {
        if (isset($value['create']) && $value['create'] instanceof Category) {
            return $value['create'];
        } elseif (isset($value['selected']) && $value['selected'] instanceof Category) {
            return $value['selected'];
        } else {
            return null;
        }
    }
}