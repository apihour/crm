<?php

namespace Apihour\ProductBundle\Controller;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Apihour\UserBundle\Entity\Role;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tutto\SecurityBundle\Configuration\Authorization;

/**
 * Class ProductAnalyticController
 * @package Apihour\ProductBundle\Controller
 *
 * @Authorization({Role::CONTRACTOR})
 */
class ProductAnalyticController {
    /**
     * @Route("/test/json", name="test")
     */
    public function testAction() {
        $series = [];

        for ($i=1; $i<100; $i++) {
            $series[] = [
                'x' => $i,
                'y' => rand(0, 1000)
            ];
        }

        return new JsonResponse([[
            'key' => 'Produkt 1',
            'values' => $series
        ]]);
    }
} 