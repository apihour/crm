<?php

namespace Apihour\ContractorBundle\Controller;

use Doctrine\Common\Persistence\Mapping\MappingException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

use Tutto\CommonBundle\Form\Subscriber\IgnoreNonSubmittedFieldSubscriber;
use Tutto\DataGridBundle\Controller\AbstractDataGridController;
use Apihour\ContractorBundle\Entity\AbstractContractor;
use Apihour\ContractorBundle\DataGrid\Contractor\DataProvider;
use Apihour\ContractorBundle\DataGrid\Contractor\FiltersType;
use Apihour\ContractorBundle\DataGrid\Contractor\Grid;
use Apihour\ContractorBundle\Form\Type\ContractorType;
use Apihour\ContractorBundle\Entity\Buyer;
use Apihour\ContractorBundle\Entity\Seller;
use LogicException;
use Exception;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Tutto\SecurityBundle\Configuration\Authorization;
use Tutto\CommonBundle\Configuration\PageData;
use Tutto\CommonBundle\Configuration\Metadata;
use Apihour\UserBundle\Entity\Role;

/**
 * Class ContractorController
 * @package Apihour\ContractorBundle\Controller
 */
class ContractorController extends AbstractDataGridController {
    /**
     * @Route(
     *      "/contractors/list/{page}/{limit}/{order}",
     *      name="apihour_contractors_list",
     *      defaults={"page"=1, "limit"=50, "order"="desc"},
     *      requirements={"page"="\d+", "limit"="\d+", "order"="(asc|desc)"}
     * )
     * @PageData(title="contractor.list.title", subtitle="contractor.list.subtitle")
     * @Metadata(title="contractor.list.title", description="contractor.list.subtitle")
     * @Template()
     * @Authorization({Role::MEMBER})
     */
    public function listAction() {
        return $this->getDataGridResponse(
            new Grid(),
            new DataProvider(),
            new FiltersType()
        );
    }

    /**
     * @Route("/contractor/seller/create",
     *      name="apihour_contractor_seller_create"
     * )
     * @Route("/contractor/seller/copy/{id}",
     *      name="apihour_contractor_seller_copy",
     *      requirements={"id"="\d+"}
     * )
     * @Authorization({Role::ADMIN, Role::CONTRACTOR})
     * @Template("@ApihourContractor/Contractor/form.html.twig")
     * @PageData(title="contractor:create.seller.title", subtitle="contractor:create.seller.subtitle")
     * @Metadata(title="contractor:create.seller.title", description="contractor:create.seller.subtitle")
     *
     * @param Request $request
     * @param Seller $seller
     * @return array
     */
    public function createSellerAction(Request $request, Seller $seller = null) {
        return $this->createAction($request, $seller !== null ? $seller : new Seller());
    }

    /**
     * @Route("/contractor/buyer/create",
     *      name="apihour_contractor_buyer_create"
     * )
     * @Route("/contractor/buyer/copy/{id}",
     *      name="apihour_contractor_buyer_copy",
     *      requirements={"id"="\d+"}
     * )
     * @Authorization({Role::ADMIN, Role::CONTRACTOR})
     * @Template("@ApihourContractor/Contractor/form.html.twig")
     * @PageData(title="contractor:create.buyer.title", subtitle="contractor:create.buyer.subtitle")
     * @Metadata(title="contractor:create.buyer.title", description="contractor:create.buyer.subtitle")
     *
     * @param Request $request
     * @param Buyer $buyer
     * @return array
     */
    public function createBuyerAction(Request $request, Buyer $buyer = null) {
        return $this->createAction($request, $buyer, $buyer !== null ? $buyer : new Buyer());
    }

    /**
     * @param Request $request
     * @param AbstractContractor $contractor
     * @return array|RedirectResponse
     * @throws MappingException
     * @throws Exception
     */
    protected function createAction(Request $request, AbstractContractor $contractor = null) {
        return $this->processForm(new ContractorType(), $contractor, $request);
    }

    /**
     * @Route(
     *      "/contractor/view/{id}",
     *      name="apihour_contractor_view",
     *      requirements={"id"="\d+"}
     * )
     * @Template()
     * @ParamConverter()
     * @PageData(title="contractor.view.title", subtitle="contractor.view.subtitle")
     * @Metadata(title="contractor.view.title", description="contractor.view.subtitle")
     * @Authorization({Role::ADMIN, Role::CONTRACTOR})
     *
     * @param AbstractContractor $contractor
     * @return array
     */
    public function viewAction(AbstractContractor $contractor) {
        return ['contractor' => $contractor];
    }

    /**
     * @Route(
     *      "/contractor/edit/{id}",
     *      name="apihour_contractor_edit",
     *      requirements={"id"="\d+"}
     * )
     * @ParamConverter()
     * @PageData(title="contractor.edit.title", subtitle="contractor.edit.subtitle")
     * @Metadata(title="contractor.edit.title", description="contractor.edit.subtitle")
     * @Authorization({Role::ADMIN, Role::CONTRACTOR})
     *
     * @param Contractor $contractor
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     */
    public function editAction(Contractor $contractor, Request $request) {
    }

    /**
     * @Route(
     *      "/contractor/delete/{id}",
     *      name="apihour_contractor_delete",
     *      requirements={"id"="\d+"}
     * )
     * @Template()
     * @ParamConverter()
     * @PageData(title="contractor.delete.title", subtitle="contractor.delete.subtitle")
     * @Metadata(title="contractor.delete.title", description="contractor.delete.subtitle")
     * @Authorization({Role::ADMIN, Role::CONTRACTOR})
     *
     * @param Contractor $contractor
     * @return array
     */
    public function deleteAction(Contractor $contractor) {
    }

    /**
     * @Route(
     *      "/contractor/changedata/{id}",
     *      name="apihour_contractor_changedata",
     *      requirements={"id"="\d+"}
     * )
     *
     * @Authorization({Role::ADMIN, Role::CONTRACTOR})
     * @ParamConverter()
     * @Template()
     * @Method("POST")
     *
     * @param Request $request
     * @param AbstractContractor $contractor
     * @return mixed
     */
    public function changeDataAction(AbstractContractor $contractor, Request $request) {
        $formBuilder = $this->createFormBuilder(
            $contractor,
            [
                'csrf_protection'    => false,
                'data_class'         => AbstractContractor::class,
                'cascade_validation' => true,
            ]
        );

        $formBuilder
            ->add('firstname', 'text', ['required' => false, 'property_path' => 'person.firstname'])
            ->add('shortname', 'text', ['required' => false, 'constraints' => new NotBlank()])
            ->addEventSubscriber(new IgnoreNonSubmittedFieldSubscriber());

        return parent::updateData($formBuilder, $contractor, $request);
    }
}