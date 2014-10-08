<?php

namespace Apihour\UserBundle\Repository\Account;

use Apihour\UserBundle\Entity\Account;
use Apihour\UserBundle\Entity\Account\AccountOption;
use Doctrine\ORM\NoResultException;
use Tutto\CommonBundle\Repository\AbstractEntityRepository;

/**
 * Class AccountOptionRepository
 * @package Apihour\UserBundle\Repository\Account
 */
class AccountOptionRepository extends AbstractEntityRepository {
    /**
     * @param string $group
     * @param string $name
     * @return null|AccountOption
     */
    public function get($group, $name) {
        try {
            return $this->findOneBy(['group' => $group, 'name' => $name]);
        } catch (NoResultException $ex) {
            return null;
        }
    }
} 