<?php

namespace Apihour\UserBundle\DataGrid\UserProfiles;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Tutto\DataGridBundle\DataGrid\AbstractDataGridBuilder;
use Tutto\DataGridBundle\DataGrid\AbstractFilterType;
use Tutto\SecurityBundle\Repository\RoleRepository;
use Tutto\DataGridBundle\DataGrid\DataProvider\DataProviderInterface;
use Tutto\DataGridBundle\DataGrid\Grid\Builder\GridDefinitionInterface;
use Apihour\UserBundle\Entity\User\UserAccount;
use Apihour\UserBundle\Entity\Role;
use Apihour\UserBundle\Entity\User;
use Apihour\UserBundle\DataGrid\UserProfiles\Contractor;
use LogicException;

class GridBuilder extends AbstractDataGridBuilder {
    /**
     * @var UserAccount
     */
    protected $userAccount;

    /**
     * @param UserAccount $userAccount
     * @param ContainerInterface $container
     */
    public function __construct(UserAccount $userAccount, ContainerInterface $container = null) {
        parent::__construct($container);
        $this->userAccount = $userAccount;
    }

    /**
     * @return GridDefinitionInterface
     */
    public function getGridDefinition() {
        if ($this->isAllowedTo(Role::CONTRACTOR)) {
            return new Contractor\GridDefinition();
        } else {
            throw $this->throwException();
        }
    }

    /**
     * @return AbstractFilterType
     */
    public function getFiltersType() {
        if ($this->isAllowedTo(Role::CONTRACTOR)) {
            return new Contractor\FiltersType();
        } else {
            throw $this->throwException();
        }
    }

    /**
     * @return DataProviderInterface
     */
    public function getDataProvider() {
        if ($this->isAllowedTo(Role::CONTRACTOR)) {
            return new Contractor\DataProvider($this->userAccount);
        } else {
            throw $this->throwException();
        }
    }

    /**
     * @param $roleName
     * @return bool
     */
    protected function isAllowedTo($roleName) {
        /** @var RoleRepository $roleRepository */
        $roleRepository = $this->getRepository(Role::class);

        /** @var User $user */
        if (($user = $this->getUser()) && ($account = $user->getCurrentUserAccount())) {
            return $account->getRole()->isAllowed($roleRepository->getByName($roleName));
        } else {
            return false;
        }
    }

    /**
     * @return LogicException
     */
    protected function throwException() {
        return new LogicException("Błąd");
    }
}