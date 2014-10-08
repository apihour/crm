<?php

namespace Apihour\UserBundle\Entity\Account;

use Apihour\SettingsBundle\Entity\AbstractDataOption;
use Apihour\SettingsBundle\Entity\DataOptionEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AccountOption
 * @package Apihour\UserBundle\Entity\Account
 *
 * @ORM\Entity(repositoryClass="Apihour\UserBundle\Repository\Account\AccountOptionRepository")
 * @ORM\Table(name="accounts_options", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unique_option", columns={"group", "name"})
 * })
 */
class AccountOption extends AbstractDataOption {
    const GROUP_SETTLEMENTS_PREFIX = 'settlements_prefix';

    const NAME_FOR_INVOICES = 'for_invoices';
    const NAME_FOR_BILLS    = 'for_bills';
    const NAME_FOR_PROFORMA = 'for_proforma';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }
} 