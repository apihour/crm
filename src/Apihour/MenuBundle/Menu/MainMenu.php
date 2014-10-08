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
            } elseif ($role->isAllowed($roleRepository->getByName(Role::ADMIN))) {
                $this->createMenuForAdmin($factory, $menu);
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
        $contractorCreateMenu->setLabel('menu:contractors.create.index');
        $contractorCreateMenu->setExtra('routes', 'apihour_contractor_create');
        $contractorCreateMenu->setUri('javascript:;');
        $contractorCreateMenu->setChildrenAttribute('class', 'sub-menu');

        $contractorCreateBuyerMenu = new MenuItem('apihour_contractor_buyer_create', $factory);
        $contractorCreateBuyerMenu->setLabel('menu:contractors.create.buyer');
        $contractorCreateBuyerMenu->setUri($this->getRouter()->generate('apihour_contractor_buyer_create'));
        $contractorCreateBuyerMenu->setExtra('routes', 'apihour_contractor_buyer_create');
        $contractorCreateMenu->addChild($contractorCreateBuyerMenu);

        $contractorCreateSellerMenu = new MenuItem('apihour_contractor_seller_create', $factory);
        $contractorCreateSellerMenu->setLabel('menu:contractors.create.seller');
        $contractorCreateSellerMenu->setUri($this->getRouter()->generate('apihour_contractor_seller_create'));
        $contractorCreateSellerMenu->setExtra('routes', 'apihour_contractor_seller_create');
        $contractorCreateMenu->addChild($contractorCreateSellerMenu);

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

        /** Menu dla rozliczeń (oprócz dla zwykłego pracownika) */
        if (!in_array($this->getCurrentUserAccount()->getRole()->getName(), [Role::CONTRACTOR_WORKER])) {
            $settlementsMenu = new MenuItem('settlements', $factory);
            $settlementsMenu->setLabel('menu:settlements.index');
            $settlementsMenu->setUri('javascript:;');
            $settlementsMenu->setAttribute('icon', 'fa-dollar');
            $settlementsMenu->setExtra('routes', 'apihour_products');
            $settlementsMenu->setChildrenAttribute('class', 'sub-menu');

            /** Przychody */
            $settlementsIncomeMenu = new MenuItem('settlements_incomes', $factory);
            $settlementsIncomeMenu->setLabel('menu:settlements.incomes.index');
            $settlementsIncomeMenu->setUri('javascript:;');
            $settlementsIncomeMenu->setExtra('routes', 'apihour_settlements_incomes');
            $settlementsIncomeMenu->setChildrenAttribute('class', 'sub-menu');
            $settlementsMenu->addChild($settlementsIncomeMenu);

            /** Faktura przychów */
            $settlementsIncomeCreateInvoiceMenu = new MenuItem('apihour_settlements_income_create_invoice', $factory);
            $settlementsIncomeCreateInvoiceMenu->setLabel('menu:settlements.create.invoice');
            $settlementsIncomeCreateInvoiceMenu->setUri($this->getRouter()->generate('apihour_settlements_income_create_invoice'));
            $settlementsIncomeCreateInvoiceMenu->setExtra('routes', 'apihour_settlements_income_create_invoice');
            $settlementsIncomeMenu->addChild($settlementsIncomeCreateInvoiceMenu);

            /** Rachunek przychód */
            $settlementsIncomeCreateBillMenu = new MenuItem('apihour_settlements_income_create_bill', $factory);
            $settlementsIncomeCreateBillMenu->setLabel('menu:settlements.create.bill');
            $settlementsIncomeCreateBillMenu->setUri($this->getRouter()->generate('apihour_settlements_income_create_bill'));
            $settlementsIncomeCreateBillMenu->setExtra('routes', 'apihour_settlements_income_create_bill');
            $settlementsIncomeMenu->addChild($settlementsIncomeCreateBillMenu);

            /** Koszty */
            $settlementsExpenseMenu = new MenuItem('settlements_expenses', $factory);
            $settlementsExpenseMenu->setLabel('menu:settlements.expenses.index');
            $settlementsExpenseMenu->setUri('javascript:;');
            $settlementsExpenseMenu->setExtra('routes', 'apihour_settlements_expenses');
            $settlementsExpenseMenu->setChildrenAttribute('class', 'sub-menu');
            $settlementsMenu->addChild($settlementsExpenseMenu);

            /** Faktura koszt */
            $settlementsExpenseInvoiceMenu = new MenuItem('apihour_settlements_expense_create_invoice', $factory);
            $settlementsExpenseInvoiceMenu->setLabel('menu:settlements.create.invoice');
            $settlementsExpenseInvoiceMenu->setUri($this->getRouter()->generate('apihour_settlements_expense_create_invoice'));
            $settlementsExpenseInvoiceMenu->setExtra('routes', 'apihour_settlements_expense_create_invoice');
            $settlementsExpenseMenu->addChild($settlementsExpenseInvoiceMenu);

            /** Rachunek koszt */
            $settlementsExpenseBillMenu = new MenuItem('apihour_settlements_expense_create_bill', $factory);
            $settlementsExpenseBillMenu->setLabel('menu:settlements.create.bill');
            $settlementsExpenseBillMenu->setUri($this->getRouter()->generate('apihour_settlements_expense_create_bill'));
            $settlementsExpenseBillMenu->setExtra('routes', 'apihour_settlements_expense_create_bill');
            $settlementsExpenseMenu->addChild($settlementsExpenseBillMenu);

            $menu->addChild($settlementsMenu);
        }

        $settingsMenu = new MenuItem('apihour_settings', $factory);
        $settingsMenu->setLabel('menu:settings.index');
        $settingsMenu->setUri('javascript:;');
        $settingsMenu->setAttribute('icon', 'fa-cogs');
        $settingsMenu->setChildrenAttribute('class', 'sub-menu');

        if (in_array($this->getCurrentUserAccount()->getRole()->getName(), [Role::CONTRACTOR_OWNER, Role::CONTRACTOR_MANAGER])) {
            $settingsAccountMenu = new MenuItem('apihour_settings_account', $factory);
            $settingsAccountMenu->setLabel('menu:settings.accounts');
            $settingsAccountMenu->setUri($this->getRouter()->generate('apihour_settings_account', ['id' => $this->getCurrentUserAccountId()]));
            $settingsAccountMenu->setExtra('routes', 'apihour_settings_account');
            $settingsMenu->addChild($settingsAccountMenu);
        }

        $menu->addChild($settingsMenu);
    }

    /**
     * @param FactoryInterface $factory
     * @param ItemInterface $menu
     */
    protected function createMenuForClients(FactoryInterface $factory, ItemInterface $menu) {
    }

    /**
     * @param FactoryInterface $factory
     * @param ItemInterface $menu
     */
    protected function createMenuForAdmin(FactoryInterface $factory, ItemInterface $menu) {
        $settingsMenu = new MenuItem('settings', $factory);
        $settingsMenu->setLabel('menu:settings.index');
        $settingsMenu->setUri('javascript:;');
        $settingsMenu->setAttribute('icon', 'fa-cogs');
        $settingsMenu->setExtra('routes', 'apihour_admin_account_settings');
        $settingsMenu->setChildrenAttribute('class', 'sub-menu');

        /** Menu opcji dla kont (accounts_options) */
        $accountOptionsMenu = new MenuItem('apihour_admin_account_options', $factory);
        $accountOptionsMenu->setLabel('menu:settings.accounts.index');
        $accountOptionsMenu->setUri('javascript:;');
        $accountOptionsMenu->setExtra('routes', 'apihour_admin_account_options');
        $accountOptionsMenu->setChildrenAttribute('class', 'sub-menu');
        $settingsMenu->addChild($accountOptionsMenu);

        $accountOptionListMenu = new MenuItem('apihour_admin_account_options', $factory);
        $accountOptionListMenu->setLabel('menu:settings.accounts.list');
        $accountOptionListMenu->setUri($this->getRouter()->generate('apihour_admin_account_options'));
        $accountOptionListMenu->setExtra('routes', 'apihour_admin_account_options');
        $accountOptionsMenu->addChild($accountOptionListMenu);

        $accountOptionCreateMenu = new MenuItem('apihour_admin_account_option_create', $factory);
        $accountOptionCreateMenu->setLabel('menu:settings.accounts.create');
        $accountOptionCreateMenu->setUri($this->getRouter()->generate('apihour_admin_account_option_create'));
        $accountOptionCreateMenu->setExtra('routes', 'apihour_admin_account_option_create');
        $accountOptionsMenu->addChild($accountOptionCreateMenu);

        $accountOptionEditMenu = new MenuItem('apihour_admin_account_option_edit', $factory);
        $accountOptionEditMenu->setExtra('routes', 'apihour_admin_account_option_edit');
        $accountOptionEditMenu->setDisplay(false);
        $accountOptionsMenu->addChild($accountOptionEditMenu);

        /** Menu opcji dla kontrahentów (contractors_options) */
        $contractorOptionsMenu = new MenuItem('apihour_admin_contractor_options_index', $factory);
        $contractorOptionsMenu->setLabel('menu:settings.contractors.index');
        $contractorOptionsMenu->setUri('javascript:;');
        $contractorOptionsMenu->setExtra('routes', 'apihour_admin_contractor_options');
        $contractorOptionsMenu->setChildrenAttribute('class', 'sub-menu');
        $settingsMenu->addChild($contractorOptionsMenu);

        $contractorOptionListMenu = new MenuItem('apihour_admin_contractor_options', $factory);
        $contractorOptionListMenu->setLabel('menu:settings.contractors.list');
        $contractorOptionListMenu->setUri($this->getRouter()->generate('apihour_admin_contractor_options'));
        $contractorOptionListMenu->setExtra('routes', 'apihour_admin_contractor_options');
        $contractorOptionsMenu->addChild($contractorOptionListMenu);

        $contractorOptionCreateMenu = new MenuItem('apihour_admin_contractor_option_create', $factory);
        $contractorOptionCreateMenu->setLabel('menu:settings.accounts.create');
        $contractorOptionCreateMenu->setUri($this->getRouter()->generate('apihour_admin_contractor_option_create'));
        $contractorOptionCreateMenu->setExtra('routes', 'apihour_admin_contractor_option_create');
        $contractorOptionsMenu->addChild($contractorOptionCreateMenu);

        $menu->addChild($settingsMenu);
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