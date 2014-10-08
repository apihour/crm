<?php

namespace Apihour\ProductBundle\Controller;

use Apihour\ProductBundle\DataGrid\ProductList\DataProvider;
use Apihour\ProductBundle\DataGrid\ProductList\FiltersType;
use Apihour\ProductBundle\DataGrid\ProductList\Grid;
use Apihour\ProductBundle\Form\Type\ProductType;
use Apihour\ProductBundle\Repository\ProductRepository;
use Apihour\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Tutto\CommonBundle\Util\Status;
use Tutto\DataGridBundle\Controller\AbstractDataGridController;
use Apihour\ProductBundle\Entity\Product;
use Exception;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tutto\SecurityBundle\Configuration\Authorization;
use Apihour\UserBundle\Entity\Role;
use Tutto\CommonBundle\Configuration\Metadata;
use Tutto\CommonBundle\Configuration\PageData;

/**
 * Class ProductController
 * @package Apihour\ProductBundle\Controller
 *
 * @Authorization({Role::MEMBER})
 * @Metadata(title="product:title", description="product:description")
 * @PageData(title="product:title", subtitle="product:description")
 */
class ProductController extends AbstractDataGridController {
    /**
     * @Route(
     *      "/products/{page}/{limit}",
     *      name="apihour_products",
     *      requirements={"page"="\d+", "limit"="\d+"},
     *      defaults={"page"=1, "limit"=50}
     * )
     * @Template()
     */
    public function listAction() {
        /** @var User $user */
        $user = $this->getUser();
        return $this->getDataGridResponse(
            new Grid(),
            new DataProvider($user->getCurrentUserAccount()),
            new FiltersType(),
            '@ApihourProduct/Product/list.html.twig'
        );
    }

    /**
     * @Route(
     *      "/product/edit/{id}",
     *      name="apihour_product_edit",
     *      requirements={"id"="\d+"}
     * )
     * @ParamConverter()
     * @Template()
     *
     * @param Product $product
     * @return array
     */
    public function editAction(Product $product, Request $request) {
        return $this->processForm(new ProductType($this->container), $product, $request);
    }

    /**
     * @Route(
     *      "/product/create/{type}",
     *      name="apihour_product_create",
     *      requirements={"type"="sell|buy"},
     *      defaults={"type"="sell"}
     * )
     * @Template()
     * @PageData(title="product:create.title", subtitle="product:create.description")
     *
     * @param Request $request
     * @return array
     */
    public function createAction(Request $request) {
        $product = new Product();
        if ($request->get('type') == 'buy') {
            $product->setType('buy');
        } else {
            $product->setType('sell');
        }

        return $this->processForm(new ProductType($this->container), $product, $request);
    }

    /**
     * @Route(
     *      "/product/{id}",
     *      name="apihour_product_view",
     *      requirements={"id"="\d+"}
     * )
     * @ParamConverter()
     * @Template()
     *
     * @param Product $product
     */
    public function viewAction(Product $product) {

    }

    /**
     * @Route(
     *      "/product/suspend/{id}",
     *      name="apihour_product_suspend",
     *      requirements={"id"="\d+"}
     * )
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function suspendAction(Product $product) {
        try {
            $product->setStatus(Status::DISABLED);

            $this->getEm()->persist($product);
            $this->getEm()->flush($product);

            $this->addFlashAlert('product:suspend', ['%name%' => $product->getName()]);
        } catch (Exception $ex) {
            $this->addFlashError();
        }

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * @Route(
     *      "/product/activate/{id}",
     *      name="apihour_product_activate",
     *      requirements={"id"="\d+"}
     * )
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function activateAction(Product $product) {
        try {
            $product->setStatus(Status::ENABLED);

            $this->getEm()->persist($product);
            $this->getEm()->flush($product);

            $this->addFlashSuccess('product:activate', ['%name%' => $product->getName()]);
        } catch (Exception $ex) {
            $this->addFlashError();
        }

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
} 