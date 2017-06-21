<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 09/05/2017
 * Time: 10:01
 */

namespace AppBundle\Repository;


class TaxrefFileRepository extends \Doctrine\ORM\EntityRepository
{
    public function getLastFile()
    {
        $query = $this->createQueryBuilder('t')
            ->orderBy('t.uploadedAt', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        return $query->getQuery()->getResult();
    }
}