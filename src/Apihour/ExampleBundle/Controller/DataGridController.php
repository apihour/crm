<?php

namespace Apihour\ExampleBundle\Controller;

use Apihour\ExampleBundle\DataGrid\Examples\One\DataProvider;
use Apihour\ExampleBundle\DataGrid\Examples\One\FiltersType;
use Apihour\ExampleBundle\DataGrid\Examples\One\Grid;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Tutto\DataGridBundle\Controller\AbstractDataGridController;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tutto\SecurityBundle\Configuration\Authorization;
use Apihour\UserBundle\Entity\Role;

/**
 * Class DataGridController
 * @package Apihour\ExampleBundle\Controller
 *
 * @Authorization(omit=true)
 */
class DataGridController extends AbstractDataGridController {
    /**
     * @Route("/apihour/examples/datagrids/")
     * @Template()
     *
     * @param Request $request
     */
    public function indexAction(Request $request) {

        return $this->getDataGridResponse(
            new Grid(),
            new DataProvider(),
            new FiltersType()
        );

    }

    /**
     * @Route(
     *      "/apihour/examples/datagrids/example-one/{page}/{limit}",
     *      name="apihour_examples_datagrids_one",
     *      requirements={"page"="\d+", "limit"="\d+"},
     *      defaults={"page"=1,"limit"=10}
     * )
     * @Template()
     *
     * @return Response
     */
    public function exampleOneAction(Request $request) {
    }
} 