<?php

namespace Apihour\MenuBundle\Menu;

use Apihour\UserBundle\Entity\Account\AccountHasPrivilege;
use Apihour\UserBundle\EventListener\Authorization\AccountNotSwitchedException;
use Apihour\UserBundle\Repository\Account\AccountHasPrivilegeRepository;
use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;
use Apihour\UserBundle\Entity\Role;
use Apihour\UserBundle\Entity\User;
use Apihour\UserBundle\Entity\User\UserAccount;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\MenuItem;
use Tutto\SecurityBundle\Repository\RoleRepository;

/**
 * Class AbstractMenu
 * @package Apihour\MenuBundle\Menu
 */
class MainMenu extends AbstractContainerAware {
    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function create(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'main-navigation-menu');

        $dashboardMenu = new MenuItem('dashboard', $factory);
        $dashboardMenu->setLabel('menu:dashboard');
        $dashboardMenu->setAttribute('icon', 'fa-home');
        $dashboardMenu->setExtra('routes', '_home');
        $dashboardMenu->setUri($this->getRouter()->generate('apihour_frontend_dashboard_index'));

        $menu->addChild($dashboardMenu);

        /** @var User $user */
        if (($user = $this->getUser()) instanceof User) {
            $role = $user->getCurrentUserAccount()->getRole();

            /** @var RoleRepository $roleRepository */
            $roleRepository = $this->getRepository(Role::class);

            if ($role->isAllowed($roleRepository->getByName(Role::CONTRACTOR))) {
                $this->createMenuForContractors($factory, $menu);
            } elseif ($role->isAllowed($roleRepository->getByName(Role::CLIENT))) {
                $this->createMenuForClients($factory, $menu);
            }
        }

        return $menu;
    }

    /**
     * @param FactoryInterface $factory
     * @param ItemInterface $menu
     */
    protected function createMenuForContractors(FactoryInterface $factory, ItemInterface $menu) {
        /** Menu dla użytkowników */
        $usersMenu = new MenuItem('users', $factory);
        $usersMenu->setLabel('menu:users.index');
        $usersMenu->setUri('javascript:;');
        $usersMenu->setAttribute('icon', 'fa-users');
        $usersMenu->setExtra('routes', 'apihour_user_list');
        $usersMenu->setChildrenAttribute('class', 'sub-menu');

        $userListMenu = new MenuItem('user_list', $factory);
        $userListMenu->setLabel('menu:users.list');
        $userListMenu->setExtra('routes', 'apihour_user_list');
        $userListMenu->setUri($this->getRouter()->generate('apihour_user_list'));

        $userCreateMenu = new MenuItem('user_create', $factory);
        $userCreateMenu->setLabel('menu:users.create_new');
        $userCreateMenu->setExtra('routes', 'apihour_user_create');
        $userCreateMenu->setUri($this->getRouter()->generate('apihour_user_create'));

        $userProfileMenu = new MenuItem('user_profile', $factory);
        $userProfileMenu->setLabel('menu:my_profile');
        $userProfileMenu->setExtra('routes', 'apihour_user_index');
        $userProfileMenu->setUri($this->getRouter()->generate('apihour_user_index', ['id' => $this->getCurrentUserAccountId()]));

        $usersMenu->addChild($userListMenu);
        $usersMenu->addChild($userCreateMenu);
        $usersMenu->addChild($userProfileMenu);

        /** Menu dla kontrahentów */
        $contractorsMenu = new MenuItem('contractors', $factory);
        $contractorsMenu->setLabel('menu:contractors.index');
        $contractorsMenu->setUri('javascript:;');
        $contractorsMenu->setAttribute('icon', 'fa-building');
        $contractorsMenu->setExtra('routes', 'apihour_contractors_list');
        $contractorsMenu->setChildrenAttribute('class', 'sub-menu');

        $contractorListMenu = new MenuItem('contractors_list', $factory);
        $contractorListMenu->setLabel('menu:contractors.list');
        $contractorListMenu->setExtra('routes', 'apihour_contractors_list');
        $contractorListMenu->setUri($this->getRouter()->generate('apihour_contractors_list'));

        $contractorCreateMenu = new MenuItem('contractor_create', $factory);
        $contractorCreateMenu->setLabel('menu:contractors.create');
        $contractorCreateMenu->setExtra('routes', 'apihour_contractor_create');
        $contractorCreateMenu->setUri($this->getRouter()->generate('apihour_contractor_create'));

        $contractorsMenu->addChild($contractorListMenu);
        $contractorsMenu->addChild($contractorCreateMenu);

        /** Menu dla produktów */
        $productsMenu = new MenuItem('products', $factory);
        $productsMenu->setLabel('menu:products.index');
        $productsMenu->setUri('javascript:;');
        $productsMenu->setAttribute('icon', 'fa-shopping-cart');
        $productsMenu->setExtra('routes', 'apihour_products');
        $productsMenu->setChildrenAttribute('class', 'sub-menu');

        $productListMenu = new MenuItem('products_list', $factory);
        $productListMenu->setLabel('menu:products.list');
        $productListMenu->setExtra('routes', 'apihour_products');
        $productListMenu->setUri($this->getRouter()->generate('apihour_products'));
        $productListMenu->setChildrenAttribute('class', 'sub-menu');

        $productsCreateMenu = new MenuItem('products_create', $factory);
        $productsCreateMenu->setLabel('menu:products.create');
        $productsCreateMenu->setExtra('routes', 'apihour_product_create');
        $productsCreateMenu->setUri($this->getRouter()->generate('apihour_product_create'));

        $productsMenu->addChild($productListMenu);
        $productsMenu->addChild($productsCreateMenu);

        /** Menu dla pakietów produktów */
        if ($this->getAccountControl(AccountHasPrivilegeRepository::CAN_CREATE_PRODUCTS_PACKAGES)) {
            $productPackagesMenu = new MenuItem('products_packages', $factory);
            $productPackagesMenu->setChildrenAttribute('class', 'sub-menu');
            $productPackagesMenu->setLabel('menu:products.packages.index');
            $productPackagesMenu->setExtra('routes', 'apihour_products_packages');
            $productPackagesMenu->setUri('javascript:;');

            $productPackagesListMenu = new MenuItem('products_packages_list', $factory);
            $productPackagesListMenu->setLabel('menu:products.packages.list');
            $productPackagesListMenu->setExtra('routes', 'apihour_products_packages');
            $productPackagesListMenu->setUri($this->getRouter()->generate('apihour_products_packages'));

            $productPackagesCreateMenu = new MenuItem('products_package_create', $factory);
            $productPackagesCreateMenu->setLabel('menu:products.packages.create');
            $productPackagesCreateMenu->setExtra('routes', 'apihour_products_package_create');
            $productPackagesCreateMenu->setUri($this->getRouter()->generate('apihour_products_package_create'));

            $productPackagesMenu->addChild($productPackagesListMenu);
            $productPackagesMenu->addChild($productPackagesCreateMenu);

            $productsMenu->addChild($productPackagesMenu);
        }

        $menu->addChild($usersMenu);
        $menu->addChild($contractorsMenu);
        $menu->addChild($productsMenu);
    }

    /**
     * @param FactoryInterface $factory
     * @param ItemInterface $menu
     */
    protected function createMenuForClients(FactoryInterface $factory, ItemInterface $menu) {
    }

    /**
     * @return UserAccount
     * @throws AccountNotSwitchedException
     */
    protected function getCurrentUserAccount() {
        /** @var User $user */
        if (($user = $this->getUser()) instanceof User) {
            return $user->getCurrentUserAccount();
        } else {
            throw new AccountNotSwitchedException();
        }
    }

    /**
     * @return int
     */
    protected function getCurrentUserAccountId() {
        return $this->getCurrentUserAccount()->getId();
    }

    /**
     * @param string $control
     * @return mixed
     * @throws AccountNotSwitchedException
     */
    public function getAccountControl($control) {
        /** @var AccountHasPrivilegeRepository $controlRepository */
        $controlRepository = $this->getRepository(AccountHasPrivilege::class);

        return $controlRepository->getControlValue($this->getCurrentUserAccount(), $control);
    }
} 