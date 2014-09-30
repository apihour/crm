<?php

namespace Apihour\MenuBundle\Menu;

use Apihour\UserBundle\Entity\User;
use Knp\Menu\FactoryInterface;
use Knp\Menu\MenuItem;
use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;

class TopBarToolMenu extends AbstractContainerAware {
    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function create(FactoryInterface $factory, array $options) {
        /** @var User $user */
        $user = $this->getUser();
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'dropdown-menu dropdown-dark');

        if (($account = $user->getCurrentUserAccount()) !== null) {
            /** Mój profil */
            $profileMenu = new MenuItem('myProfile', $factory);
            $profileMenu->setLabel('menu:my_profile');
            $profileMenu->setUri(
                $this->getRouter()->generate('apihour_user_index', ['id' => $account->getId()])
            );

            $menu->addChild($profileMenu);
        }

        /** Wyloguj */
        $logoutMenu = new MenuItem('logout', $factory);
        $logoutMenu->setUri($this->getRouter()->generate('_logout'));
        $logoutMenu->setLabel('menu:logout');

        $menu->addChild($logoutMenu);

        return $menu;
    }
} 