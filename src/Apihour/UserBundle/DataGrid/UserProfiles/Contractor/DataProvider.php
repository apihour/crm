<?php

namespace Apihour\UserBundle\DataGrid\UserProfiles\Contractor;

use Apihour\UserBundle\Entity\Role;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tutto\DataGridBundle\DataGrid\DataProvider\AbstractDoctrineProvider;
use Apihour\UserBundle\Entity\User\UserAccount;

class DataProvider extends AbstractDoctrineProvider {
    /**
     * @var UserAccount
     */
    protected $userAccount;

    public function __construct(UserAccount $userAccount, ContainerInterface $container = null) {
        parent::__construct($container);
        $this->userAccount = $userAccount;
    }

    /**
     * @return void
     */
    public function initQueryBuilder() {
        $this->queryBuilder = $this->getRepository(UserAccount::class)
            ->createQueryBuilder('user_account')
            ->join('user_account.account', 'account')
            ->join('user_account.role', 'role')
            ->andWhere('account.id = '.$this->userAccount->getAccount()->getId())
            ->andWhere("role.name IN (".$this->getRoles().")")
            ->getQuery();
    }

    /**
     * @return string
     */
    protected function getRoles() {
        return "'".implode('\',\'', [
            Role::CONTRACTOR_OWNER,
            Role::CONTRACTOR_TELEMARKETING,
            Role::CONTRACTOR_MANAGER,
            Role::CONTRACTOR_TRADER
        ])."'";
    }
}