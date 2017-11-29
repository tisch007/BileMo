<?php


namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

abstract class AbstractRepository extends EntityRepository
{
    protected function paginate(QueryBuilder $qb, $limit = 20, $page = 1)
    {
        if ($limit <= 0 || $page <= 0) {
            throw new \LogicException('$limit & $offstet must be greater than 0.');
        }

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));

        $pager->setCurrentPage((int)$page);
        $pager->setMaxPerPage((int) $limit);

        return $pager;
    }
}