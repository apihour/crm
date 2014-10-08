<?php

namespace Apihour\SettingsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;

use Tutto\SecurityBundle\Configuration\Authorization;
use Tutto\CommonBundle\Form\Subscriber\IgnoreNonSubmittedFieldSubscriber;
use Tutto\DataGridBundle\Controller\AbstractDataGridController;
use Apihour\SettingsBundle\DataGrid\FiltersType;
use Tutto\DataGridBundle\DataGrid\DataProvider\DoctrineDataProvider;
use Apihour\SettingsBundle\DataGrid\Grid;
use Apihour\UserBundle\Entity\Account\AccountOption;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Apihour\UserBundle\Entity\Role;

/**
 * Class OptionController
 * @package Apihour\SettingsBundle\Controller
 */
class OptionController extends AbstractDataGridController {
    /**
     * @param string $template
     * @return Response
     */
    public function getDataGrid($entityClass, $editRouteName, $createRouteName, $template = '@ApihourSettings/Option/list.html.twig') {
        return $this->getDataGridResponse(
            new Grid($editRouteName, $createRouteName),
            new DoctrineDataProvider($entityClass),
            new FiltersType(),
            $template
        );
    }

    /**
     * @Route("/changedata/{id}",
     *      name="apihour_admin_option_changedata",
     *      requirements={"id"="\d+"}
     * )
     * @Authorization({Role::ADMIN})
     * @ParamConverter()
     * @Method("POST")
     *
     * @param Request $request
     * @param AccountOption $accountOption
     * @return array
     */
    public function changeDataAction(AccountOption $accountOption, Request $request) {
        $formBuilder = $this->createFormBuilder(
            $accountOption,
            [
                'csrf_protection'    => false,
                'data_class'         => AccountOption::class,
                'cascade_validation' => true,
            ]
        );

        $formBuilder->add('shortDescription', 'text', ['required' => false, 'constraints' => [new NotBlank()]])
                    ->add('default', 'text', ['required' => false, 'constraints' => [new NotBlank()]])
                    ->add('type', 'choice', ['required' => false])
                    ->addEventSubscriber(new IgnoreNonSubmittedFieldSubscriber());

        return parent::updateData($formBuilder, $accountOption, $request);
    }
} 