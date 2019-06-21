<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VehicleRepository extends EntityRepository
{
    public function getVehiclesCount(): int
    {
        return intval($this->createQueryBuilder('v')
            ->select('count(v)')
            ->getQuery()
            ->getSingleScalarResult())
            ;
    }
}