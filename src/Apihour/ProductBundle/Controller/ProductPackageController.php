<?php

namespace Apihour\ProductBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Tutto\DataGridBundle\Controller\AbstractDataGridController;
use Apihour\ProductBundle\Entity\ProductPackage;
use Apihour\ProductBundle\Form\Type\ProductPackageType;
use Apihour\ProductBundle\Repository\ProductPackageRepository;
use Exception;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tutto\SecurityBundle\Configuration\Authorization;
use Apihour\UserBundle\Configuration\AccountPrivilege;
use Tutto\CommonBundle\Configuration\PageData;
use Tutto\CommonBundle\Configuration\Metadata;
use Apihour\UserBundle\Repository\Account\AccountHasPrivilegeRepository;
use Tutto\SecurityBundle\Entity\Role;

/**
 * Class ProductPackageController
 * @package Apihour\ProductBundle\Controller
 *
 * @Authorization(roles={Role::MEMBER})
 * @AccountPrivilege(control=AccountHasPrivilegeRepository::CAN_CREATE_PRODUCTS_PACKAGES)
 * @PageData(title="package:data.title", subtitle="package:data.subtitle")
 * @Metadata(title="package:data.title", description="package:data.description")
 */
class ProductPackageController extends AbstractDataGridController {
    /**
     * @Route(
     *      "/products/packages/{page}/{limit}",
     *      name="apihour_products_packages",
     *      requirements={"page"="\d+", "limit"="\d+"},
     *      defaults={"page"=1, "limit"=30}
     * )
     * @Template()
     *
     * @return Response
     */
    public function listAction() {
        return [];
    }

    /**
     * @Route(
     *      "/products/package/create",
     *      name="apihour_products_package_create"
     * )
     * @Template()
     * @ParamConverter()
     *
     * @param Request $request
     * @return array
     */
    public function createAction(Request $request) {
        return $this->processForm(new ProductPackageType($this->container), null, $request);
    }

    /**
     * @Route("/products/package/{id}",
     *      name="apihour_products_package_view",
     *      requirements={"id"="\d+"}
     * )
     * @Template()
     * @ParamConverter()
     *
     * @param ProductPackage $productPackage
     */
    public function viewAction(ProductPackage $productPackage) {

    }

    /**
     * @Route("/products/package/edit/{id}",
     *      name="apihour_products_package_edit",
     *      requirements={"id"="\d+"}
     * )
     * @ParamConverter()
     *
     * @param ProductPackage $productPackage
     */
    public function editAction(ProductPackage $productPackage) {
    }
} 