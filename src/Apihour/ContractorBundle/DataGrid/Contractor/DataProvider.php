<?php

namespace Apihour\ContractorBundle\DataGrid\Contractor;

use Apihour\ContractorBundle\Entity\AbstractContractor;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Apihour\ContractorBundle\Entity\Contractor;
use Tutto\DataGridBundle\DataGrid\DataProvider\DoctrineDataProvider;

/**
 * Class DataProvider
 * @package Apihour\ContractorBundle\DataGrid\Contractor
 */
class DataProvider extends DoctrineDataProvider {
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container = null)
    {
        parent::__construct(AbstractContractor::class, $container);
    }

    public function getQueryBuilder()
    {
        return parent::getQueryBuilder();
    }
}