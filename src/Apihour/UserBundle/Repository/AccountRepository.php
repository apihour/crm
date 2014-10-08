<?php

namespace Apihour\UserBundle\Repository;

use Apihour\FrontendBundle\Repository\AbstractEntityRepository;
use Apihour\UserBundle\Entity\Account;
use Apihour\UserBundle\Entity\Account\AccountOption;
use Apihour\UserBundle\Entity\Account\AccountHasOption;

/**
 * Class AccountRepository
 * @package Apihour\UserBundle\Repository
 */
class AccountRepository extends AbstractEntityRepository {
    /**
     * @param Account $account
     */
    public function update($account) {
        $this->getEm()->persist($account);
        $this->getEm()->flush();
    }

    /**
     * @param Account $account
     * @return AccountHasOption[]
     */
    public function getAccountOptions(Account $account) {
        $options = [];
        $query   = $this->getRepository(AccountHasOption::class)
            ->createQueryBuilder('account_has_option')
            ->select('account_has_option, account_option')
            ->join('account_has_option.option', 'account_option')
            ->andWhere('account_has_option.account = '.$account->getId());

        $ids = [];
        /** @var AccountHasOption $result */
        foreach ($query->getQuery()->getResult() as $result) {
            $ids[] = $result->getOption()->getId();
            $options[] = $result;
        }

        $query = $this->getRepository(AccountOption::class)->createQueryBuilder('account_option');
        if (!empty($ids)) {
            $query->where($query->expr()->notIn('account_option.id', '?1'));
            $query->setParameter(1, $ids);
        }

        /** @var AccountOption $result */
        foreach ($query->getQuery()->getResult() as $result) {
            $option = new AccountHasOption();
            $option->setAccount($account);
            $option->setOption($result);
            $option->setValue($result->getDefault());

            $options[] = $option;
        }

        return $options;
    }
} 