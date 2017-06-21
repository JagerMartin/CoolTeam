<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 08/05/2017
 * Time: 14:23
 */

namespace AppBundle\Repository;


class TaxrefLinkFileRepository extends \Doctrine\ORM\EntityRepository
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