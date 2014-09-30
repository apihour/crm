<?php

namespace Apihour\UserBundle\Controller;

use Apihour\UserBundle\DataGrid\UserAccount\DataProvider;
use Apihour\UserBundle\DataGrid\UserAccount\FiltersType;
use Apihour\UserBundle\DataGrid\UserAccount\Grid;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Tutto\DataGridBundle\Controller\AbstractDataGridController;
use Apihour\UserBundle\Entity\User;
use Apihour\UserBundle\Entity\User\UserAccount;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Tutto\SecurityBundle\Configuration\Authorization;
use Apihour\UserBundle\Entity\Role;

/**
 * @Authorization({Role::MEMBER})
 *
 * Class UserAccountController
 * @package Apihour\UserBundle\Controller
 */
class UserAccountController extends AbstractDataGridController {
    /**
     * @Route(
     *      "/user/accounts/list/{page}/{limit}/{order}",
     *      name="apihour_user_accounts_list",
     *      defaults={"page"=1, "limit"=50, "order"="desc"},
     *      requirements={"page"="\d+", "limit"="\d+", "order"="(asc|desc)"}
     * )
     *
     * @param Request $request
     * @return array
     */
    public function userAccountsAction(Request $request) {
        /** @var User $user */
        if ($this->getUser() instanceof User) {
            return $this->getDataGridResponse(
                new Grid(),
                new DataProvider($this->getUser()),
                new FiltersType(),
                'ApihourUserBundle:Authorization:userAccounts.html.twig'
            );
        }
    }

    /**
     * @Route(
     *      "/user/account/switch/{id}",
     *      name="apihour_user_account_switch",
     *      requirements={"id"="\d+"}
     * )
     * @ParamConverter()
     *
     * @param UserAccount $userAccount
     * @return Response
     */
    public function switchAccountAction(UserAccount $userAccount) {
        /** @var User $user */
        $user = $this->getUser();
        if ($user->getId() === $userAccount->getUser()->getId()) {
            $user->switchUserAccount($userAccount);

            $this->getEm()->persist($user);
            $this->getEm()->flush();

            return $this->redirect('/');
        } else {
            $this->addFlashError('messages:account_switch:valid');
            return $this->redirect($this->generateUrl('apihour_user_accounts_list'));
        }
    }
} 