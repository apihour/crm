<?php

namespace Apihour\ContractorBundle\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

use Apihour\ContractorBundle\DataGrid\Contractor\DataProvider;
use Apihour\ContractorBundle\DataGrid\Contractor\FiltersType;
use Apihour\ContractorBundle\DataGrid\Contractor\Grid;
use Apihour\ContractorBundle\Entity\Contractor;
use Apihour\ContractorBundle\Entity\Contractor\ContractorType;
use Apihour\ContractorBundle\Form\Type\CompanyContractorType;
use Apihour\ContractorBundle\Form\Type\PersonContractorType;
use Tutto\CommonBundle\Form\Subscriber\IgnoreNonSubmittedFieldSubscriber;
use Tutto\DataGridBundle\Controller\AbstractDataGridController;
use Apihour\ContractorBundle\Repository\ContractorRepository;
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
     * @Route(
     *      "/contractor/create",
     *      name="apihour_contractor_create"
     * )
     * @Template()
     * @PageData(title="contractor.create.title", subtitle="contractor.create.subtitle")
     * @Metadata(title="contractor.create.title", description="contractor.create.subtitle")
     * @Authorization({Role::ADMIN, Role::CONTRACTOR})
     *
     * @param Request $request
     */
    public function createAction(Request $request) {

        $contractor = new Contractor();

        $form = $this->createForm(new PersonContractorType($contractor), $contractor);
        $view = '@ApihourContractor/Contractor/edit/person.form.html.twig';

        return $this->render(
            $view,
            array_merge(
                ['contractor' => $contractor],
                $this->processForm($form, $request)
            )
        );
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
     * @param Contractor $contractor
     * @return array
     */
    public function viewAction(Contractor $contractor) {
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

        if ($contractor->getType() == ContractorType::TYPE_PERSON) {
            $form = $this->createForm(new PersonContractorType($contractor), $contractor);
            $view = '@ApihourContractor/Contractor/edit/person.form.html.twig';
        }
        elseif ($contractor->getType() == ContractorType::TYPE_COMPANY) {
            $form = $this->createForm(new CompanyContractorType($contractor), $contractor);
            $view = '@ApihourContractor/Contractor/edit/company.form.html.twig';
        }
        else {
            throw new LogicException("Contractor type is not valid.");
        }

        return $this->render(
            $view,
            array_merge(
                ['contractor' => $contractor],
                $this->processForm($form, $request)
            )
        );
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
        /** @var ContractorRepository $repository */
        $repository = $this->getRepository(Contractor::class);
        $repository->delete($contractor);
        return [];
    }

    /**
     * @param Form $form
     * @param Request $request
     * @return array
     */
    protected function processForm(Form $form, Request $request) {
        if ($request->isMethod('POST')) {
            if ($form->submit($request)->isValid()) {
                /** @var Contractor $contractor */
                $contractor = $form->getData();
                $this->getEm()->beginTransaction();
                try {
                    /** @var ContractorRepository $repository */
                    $repository = $this->getRepository(Contractor::class);
                    $repository->update($contractor);

                    $this->addFlashSuccess();
                    $this->getEm()->commit();
                } catch (Exception $ex) {
                    $this->addFlashError($ex->getMessage() .''.get_class($ex));
                    $this->getEm()->rollback();
                }
            } else {
                $this->addFormFlashError($form);
            }
        }
        return ['form' => $form->createView()];
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
     * @param Contractor $contractor
     * @return mixed|void
     */
    public function changeDataAction(Contractor $contractor, Request $request) {
        $formBuilder = $this->createFormBuilder(
            $contractor,
            [
                'csrf_protection'    => false,
                'data_class'         => Contractor::class,
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