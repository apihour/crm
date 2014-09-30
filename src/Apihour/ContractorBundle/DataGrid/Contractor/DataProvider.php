<?php
/**
 * Created by PhpStorm.
 * User: pkrawczyk
 * Date: 18.09.14
 * Time: 12:55
 */

namespace Apihour\ContractorBundle\DataGrid\Contractor;


use Apihour\ContractorBundle\Entity\Contractor;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;
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
        parent::__construct(Contractor::class, $container);
    }

    public function getQueryBuilder()
    {
        return parent::getQueryBuilder();
    }
}