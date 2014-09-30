<?php

namespace Apihour\FrontendBundle\Repository;

use Tutto\CommonBundle\Tools\Status;
use Apihour\FrontendBundle\Entity\Category;
use Apihour\UserBundle\Entity\User;
use Apihour\UserBundle\Entity\User\UserAccount;
use Apihour\UserBundle\EventListener\Authorization\AccountNotSwitchedException;
use DateTime;

/**
 * Class CategoryRepository
 * @package Apihour\FrontendBundle\Repository
 */
class CategoryRepository extends AbstractEntityRepository {
    /**
     * @throws AccountNotSwitchedException
     * @return Category[]
     */
    public function getCategoriesForCurrentUser() {
        return $this->getCategories($this->getCurrentUserAccount());
    }

    /**
     * @param UserAccount $userAccount
     * @return Category[]
     */
    public function getCategories(UserAccount $userAccount) {
        return $this->createQueryBuilder('category')
                ->join('category.ownerUserAccount', 'owner')
                ->andWhere('owner.id = '.$userAccount->getId())
                ->andWhere('category.status = '.Status::ENABLED.' AND category.isDeleted = FALSE')
                ->getQuery()
                ->getResult();
    }

    /**
     * @param Category $category
     * @throws AccountNotSwitchedException
     */
    public function update(Category $category) {
        if ($category->getOwnerUserAccount() === null) {
            $category->setOwnerUserAccount($this->getCurrentUserAccount());
        }
        if ($category->getCreatedBy() === null) {
            $category->setCreatedBy($this->getCurrentUserAccount());
        }

        $category->setModifiedBy($this->getCurrentUserAccount());
        $category->setModifiedAt(new DateTime());

        $this->getEm()->persist($category);
        $this->getEm()->flush();
    }
} 