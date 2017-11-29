<?php

namespace AppBundle\Repository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MobilephoneRepository extends AbstractRepository
{
    public function search($order = 'asc', $limit = 20, $page = 1)
    {

        $qb = $this
            ->createQueryBuilder('a')
            ->select('a')
            ->orderBy('a.id', $order)
        ;

        return $this->paginate($qb, $limit, $page);
    }
}