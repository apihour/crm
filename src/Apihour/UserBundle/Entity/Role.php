<?php

namespace Apihour\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Tutto\SecurityBundle\Entity\Role as BaseRole;

/**
 * Class Role
 * @package Apihour\UserBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Tutto\SecurityBundle\Repository\RoleRepository")
 * @ORM\Table(name="roles")
 */
class Role extends BaseRole {
    const ADMIN                    = 'ADMIN';
    const CLIENT                   = 'CLIENT';
    const CONTRACTOR               = 'CONTRACTOR';
    const CONTRACTOR_OWNER         = 'CONTRACTOR_OWNER';
    const CONTRACTOR_TRADER        = 'CONTRACTOR_TRADER';
    const CONTRACTOR_MANAGER       = 'CONTRACTOR_MANAGER';
    const CONTRACTOR_TELEMARKETING = 'CONTRACTOR_TELEMARKETING';
    const CONTRACTOR_WORKER        = 'CONTRACTOR_WORKER';
} 