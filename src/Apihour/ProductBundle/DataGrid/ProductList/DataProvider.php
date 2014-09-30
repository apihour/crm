<?php

namespace Apihour\ProductBundle\DataGrid\ProductList;

use Apihour\UserBundle\Entity\User\UserAccount;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Apihour\ProductBundle\Entity\Product;
use Tutto\DataGridBundle\DataGrid\DataProvider\DoctrineDataProvider;

/**
 * Class DataProvider
 * @package Apihour\ProductBundle\DataGrid\ProductList
 */
class DataProvider extends DoctrineDataProvider {
    /**
     * @var UserAccount
     */
    protected $userAccount;

    /**
     * @param UserAccount $userAccount
     * @param ContainerInterface $container
     */
    public function __construct(UserAccount $userAccount, ContainerInterface $container = null) {
        $this->userAccount = $userAccount;
        parent::__construct(Product::class, $container);
    }

    public function getQueryBuilder() {
        return parent::getQueryBuilder()
            ->join('root.ownerUserAccount', 'owner_user_account')
            ->andWhere('owner_user_account.id = '.$this->userAccount->getId());
    }


} 