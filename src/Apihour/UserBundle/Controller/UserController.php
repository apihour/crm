<?php

namespace Apihour\UserBundle\Controller;

use Apihour\UserBundle\DataGrid\UserProfiles\GridBuilder;
use Apihour\UserBundle\EventListener\Authorization\AccountNotSwitchedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

use Tutto\SecurityBundle\Listeners\Authorization\PermissionDeniedException;
use Tutto\DataGridBundle\Controller\AbstractDataGridController;
use Apihour\UserBundle\Form\Type\Profile\ClientProfileType;
use Apihour\UserBundle\Form\Type\Profile\WorkerProfileType;
use Apihour\UserBundle\Repository\UserAccountRepository;
use Apihour\UserBundle\Entity\User\UserAccount;
use Apihour\UserBundle\Entity\User;
use Apihour\FileBundle\Repository\FileRepository;
use LogicException;
use Exception;
use DateTime;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Tutto\SecurityBundle\Configuration\Authorization;
use Tutto\CommonBundle\Configuration\Metadata;
use Tutto\CommonBundle\Configuration\PageData;
use Apihour\UserBundle\Entity\Role;

/**
 * Class UserController
 * @package Apihour\UserBundle\Controller
 */
class UserController extends AbstractDataGridController {
    /**
     *@Route(
     *      "/user/profile/{id}",
     *      name="apihour_user_index",
     *      requirements={"id"="\d+"}
     * )
     * @ParamConverter()
     * @Template()
     * @Metadata(title="user.metadata.title", description="user.metadata.description")
     * @PageData(title="user.data.title", subtitle="user.data.subtitle")
     * @Authorization({Role::MEMBER})
     *
     * @param UserAccount $userAccount
     * @return array
     */
    public function indexAction(UserAccount $userAccount) {
        return [
            'userAccount' => $userAccount,
            'tab'         => $this->getRequest()->isMethod('POST') ? 'edit' : 'view'
        ];
    }

    /**
     * @Route(
     *      "/user/profiles/{page}",
     *      name="apihour_user_list",
     *      requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Template()
     * @PageData(title="users.data.title", subtitle="users.data.subtitle")
     * @Metadata(title="users.data.title", description="users.data.subtitle")
     * @Authorization({Role::ADMIN, Role::CONTRACTOR})
     *
     * @param Request $request
     * @return array|Response
     * @throws AccountNotSwitchedException
     */
    public function listAction(Request $request) {
        return [];
    }

    /**
     * @Route(
     *      "/user/create/",
     *      name="apihour_user_create"
     * )
     * @Template()
     * @PageData(title="users.create_new.data.title", subtitle="users.create_new.data.subtitle")
     * @Metadata(title="users.create_new.data.title", description="users.create_new.data.subtitle")
     * @Authorization({Role::ADMIN, Role::CONTRACTOR})
     *
     * @param Request $request
     */
    public function createAction(Request $request) {

    }

    /**
     * @Route(
     *      "/user/profile/edit/{id}",
     *      name="apihour_user_edit",
     *      requirements={"id"="\d+"}
     * )
     * @Metadata(title="messages:user.edit.metadata.title", description="messages:user.edit.metadata.description")
     * @Authorization({Role::MEMBER})
     *
     * @param UserAccount $userAccount
     * @return array
     */
    public function editAction(UserAccount $userAccount, Request $request) {
        if (in_array($userAccount->getRole()->getName(), [Role::CONTRACTOR_OWNER])) {
            $form = $this->createForm(new WorkerProfileType($userAccount), $userAccount);
            $view = '@ApihourUser/User/edit/worker.form.html.twig';
        } elseif ($userAccount->getRole()->getName() === Role::CLIENT) {
            $form = $this->createForm(new ClientProfileType($userAccount), $userAccount);
            $view = '@ApihourUser/User/edit/client.form.html.twig';
        } else {
            throw new LogicException("User role is not valid.");
        }

        return $this->render(
            $view,
            array_merge(
                ['userAccount' => $userAccount],
                $this->processForm($form, $userAccount, $request)
            )
        );
    }

    /**
     * @Route(
     *      "/user/profile/view/{id}",
     *      name="apihour_user_view",
     *      requirements={"id"="\d+"}
     * )
     * @Template()
     * @ParamConverter()
     * @PageData(title="user.view.data.title", subtitle="user.view.data.subtitle")
     * @Authorization({Role::MEMBER})
     *
     * @param UserAccount $userAccount
     * @return array
     */
    public function viewAction(UserAccount $userAccount) {
        return ['userAccount' => $userAccount];
    }

//    /**
//     * @param Form $form
//     * @param Request $request
//     * @return array
//     */
//    protected function processForm(Form $form, Request $request) {
//        if ($request->isMethod('POST')) {
//            if ($form->submit($request)->isValid()) {
//                /** @var UserAccount $userAccount */
//                $userAccount = $form->getData();
//
//                $this->getEm()->beginTransaction();
//                try {
//                    /** @var UserAccountRepository $repository */
//                    $repository = $this->getRepository(UserAccount::class);
//                    $repository->update($userAccount);
//
//                    $this->addFlashSuccess();
//                    $this->getEm()->commit();
//                } catch (Exception $ex) {
//                    $this->addFlashError('formIsNotValid');
//                    $this->getEm()->rollback();
//                }
//            } else {
//                var_dump($form->getErrorsAsString());
//                $this->addFlashError('formIsNotValid');
//            }
//        }
//
//        return ['form' => $form->createView()];
//    }
} 