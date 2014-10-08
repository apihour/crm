<?php

namespace Apihour\SettlementBundle\Entity\Settlement;

use Apihour\SettlementBundle\Entity\AbstractSettlement;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class File
 * @package Apihour\SettlementBundle\Entity\Settlement
 *
 * @ORM\Entity()
 * @ORM\Table(name="settlements_has_files")
 */
class File {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\SettlementBundle\Entity\AbstractSettlement", inversedBy="files")
     * @ORM\JoinColumn(name="settlement_id", referencedColumnName="id")
     *
     * @var AbstractSettlement
     */
    private $settlement;

    /**
     * @ORM\OneToOne(targetEntity="Apihour\FileBundle\Entity\File", cascade={"all"})
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var \Apihour\FileBundle\Entity\File
     */
    private $file;

    public function getFile() {
    }
} 