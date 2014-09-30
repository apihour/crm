<?php

namespace Apihour\UserBundle\DataGrid\UserAccount;

use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\Security\Core\User\UserInterface;
use Apihour\UserBundle\Entity\User\UserAccount;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tutto\CommonBundle\Util\Status;
use Tutto\DataGridBundle\DataGrid\DataProvider\DoctrineDataProvider;
use Apihour\UserBundle\Entity\User;

/**
 * Class DataProvider
 * @package Apihour\UserBundle\DataGrid\Grid
 */
class DataProvider extends DoctrineDataProvider {
    /**
     * @var User
     */
    protected $user;

    /**
     * @param User $user
     * @param ContainerInterface $container
     */
    public function __construct(User $user, ContainerInterface $container = null) {
        parent::__construct(UserAccount::class, $container);
        $this->user = $user;
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder() {
        return parent::getQueryBuilder()
            ->join('root.user', 'user')
            ->join('root.account', 'account')
            ->andWhere("user.id = ".$this->user->getId())
            ->andWhere('user.enabled = TRUE')
            ->andWhere('account.status = '.Status::ENABLED. ' AND account.isDeleted = FALSE');
    }
} 