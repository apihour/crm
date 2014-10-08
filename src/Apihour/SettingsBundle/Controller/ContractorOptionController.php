<?php

namespace Apihour\SettingsBundle\Controller;

use Apihour\ContractorBundle\Entity\Contractor\ContractorOption;
use Apihour\ContractorBundle\Entity\Contractor\ContractorType;
use Apihour\SettingsBundle\DataGrid\FiltersType;
use Apihour\SettingsBundle\DataGrid\Grid;
use Apihour\SettingsBundle\Form\Type\OptionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tutto\DataGridBundle\DataGrid\DataProvider\DoctrineDataProvider;
use Tutto\SecurityBundle\Configuration\Authorization;
use Tutto\CommonBundle\Configuration\PageData;
use Apihour\UserBundle\Entity\Role;

/**
 * Class ContractorOptionController
 * @package Apihour\SettingsBundle\Controller
 *
 * @Authorization(roles={Role::ADMIN})
 * @Route("/admin/contractor/options")
 */
class ContractorOptionController extends OptionController {
    /**
     * @Route("/list/{page}/{limit}",
     *      name="apihour_admin_contractor_options",
     *      requirements={"page"="\d+", "limit"="\d+"},
     *      defaults={"page"=1, "limit"=30}
     * )
     * @PageData(title="contractor_options:list.title", subtitle="contractor_options:list.subtitle")
     *
     * @param Request $request
     * @param string $template
     * @return Response
     */
    public function listAction(Request $request, $template = '') {
        return $this->getDataGridResponse(
            new Grid('apihour_admin_contractor_option_edit', 'apihour_admin_contractor_option_create'),
            new DoctrineDataProvider(ContractorOption::class),
            new FiltersType(),
            '@ApihourSettings/Option/list.html.twig'
        );
    }

    /**
     * @Route("/edit/{id}",
     *      name="apihour_admin_contractor_option_edit",
     *      requirements={"id"="\d+"}
     * )
     * @ParamConverter()
     * @Template("@ApihourSettings/Option/form.html.twig")
     * @PageData(title="account_options:edit.title", subtitle="account_options:edit.subtitle")
     *
     * @param ContractorOption $accountOption
     * @param Request $request
     * @return array
     */
    public function editAction(ContractorOption $accountOption, Request $request) {
        return $this->processForm($this->getOptionType(), $accountOption, $request, ['redirect' => 'apihour_admin_account_settings']);
    }

    /**
     * @Route("/create/{id}",
     *      name="apihour_admin_contractor_option_create",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=null}
     * )
     * @ParamConverter()
     * @Template("@ApihourSettings/Option/form.html.twig")
     * @PageData(title="account_options:create.title", subtitle="account_options:create.subtitle")
     *
     * @param Request $request
     * @param ContractorOption $accountOption
     * @return array
     */
    public function createAction(Request $request, ContractorOption $accountOption = null) {
        $accountOption = $accountOption !== null ? clone $accountOption : new ContractorOption();
        $accountOption->setName(null);

        return $this->processForm($this->getOptionType(), $accountOption, $request);
    }

    /**
     * @return OptionType
     */
    private function getOptionType() {
        return new OptionType(
            'apihour_settings_contractor_options',
            ContractorOption::class,
            'apihour_settings_contractor_options_constraints',
            $this->getContainer()
        );
    }
} 