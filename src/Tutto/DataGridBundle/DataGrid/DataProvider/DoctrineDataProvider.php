<?php

namespace Tutto\DataGridBundle\DataGrid\DataProvider;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\QueryBuilder;

use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;

/**
 * Class DoctrineDataProvider
 * @package Tutto\DataGridBundle\DataGrid\DataProvider
 */
class DoctrineDataProvider extends AbstractContainerAware implements DataProviderInterface {
    /**
     * @var Paginator
     */
    protected $paginator;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var int
     */
    protected $limit = self::LIMIT;

    /**
     * @var int
     */
    protected $offset = 0;

    /**
     * @param ContainerInterface $entityClass
     * @param ContainerInterface $container
     */
    public function __construct($entityClass, ContainerInterface $container = null) {
        parent::__construct($container);
        $this->entityClass = (string) $entityClass;
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder() {
        return $this->getRepository($this->entityClass)->createQueryBuilder('root');
    }

    /**
     * @return array
     */
    public function getResults() {
        return $this->getPaginator()->getIterator()->getArrayCopy();
    }

    /**
     * Count elements of an object
     * @return int The custom count as an integer.
     */
    public function count() {
        return $this->getPaginator()->count();
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit = self::LIMIT) {
        $this->limit = (int) $limit;
    }

    /**
     * @return int
     */
    public function getLimit() {
        return $this->limit;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset = 0) {
        $this->offset = (int) $offset;
    }

    /**
     * @return int
     */
    public function getOffset() {
        return $this->offset;
    }

    /**
     * @param mixed $data
     * @return void
     */
    public function setData($data) {
    }

    /**
     * @return Paginator
     */
    private function getPaginator() {
        if(!$this->paginator) {
            $this->paginator = new Paginator(
                $this->getQueryBuilder()->setFirstResult($this->getOffset())->setMaxResults($this->getLimit())
            );
        }

        return $this->paginator;
    }
}