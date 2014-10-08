<?php

namespace Apihour\SettingsBundle\Controller;

use Apihour\SettingsBundle\Form\Type\AccountSetting\AccountOptionsContainerType;
use Apihour\SettingsBundle\Form\Type\DataHasOptionContainerType;
use Apihour\UserBundle\Entity\Account;
use Apihour\UserBundle\Entity\User;
use Apihour\UserBundle\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Tutto\CommonBundle\Configuration\PageData;
use Tutto\CommonBundle\Controller\AbstractController;
use Exception;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Apihour\UserBundle\Entity\Role;
use Tutto\SecurityBundle\Configuration\Authorization;

/**
 * Class AccountHasOptionController
 * @package Apihour\SettingsBundle\Controller
 *
 * @Authorization(roles={Role::CONTRACTOR_OWNER, Role::CONTRACTOR_MANAGER})
 * @PageData(title="account_options:owner.title", subtitle="account_options:owner.subtitle")
 */
class AccountHasOptionController extends AbstractController {
    /**
     * @Route("/settings/account/{id}",
     *      name="apihour_settings_account",
     *      requirements={"id"="\d+"}
     * )
     * @Template()
     * @ParamConverter()
     *
     * @param Account $account
     * @param Request $request
     * @return array
     */
    public function editAction(Account $account, Request $request) {
        /** @var AccountRepository $repository */
        $repository = $this->getRepository(Account::class);

        $account->setOptions(new ArrayCollection($repository->getAccountOptions($account)));

        return $this->processForm(
            $this->createForm(
                new DataHasOptionContainerType($account, 'apihour_settings_accounts_has_options')
            ),
            $account,
            $request
        );
    }
} 