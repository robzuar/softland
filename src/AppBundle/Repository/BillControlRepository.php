<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class BillControlRepository
 *
 * @package AppBundle\EntityRepository
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class BillControlRepository extends EntityRepository
{
    /**
     * @param $dateBegin
     * @param $dateEnd
     * @return mixed
     */
    public function getCountBetween($dateBegin, $dateEnd)
    {
        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:BillControl');

        $query = $repository->createQueryBuilder('c');


        $query
            ->select('c','billLine', 'bill')
            ->join('c.billLine', 'billLine')
            ->join('billLine.bill', 'bill')
            ->where('c.enabled = 1')
            ->andWhere('c.receivedAt BETWEEN :begin AND :end')
            ->setParameter('begin', $dateBegin)
            ->setParameter('end', $dateEnd)
        //    ->groupBy(''.$field.'')
        ;

        return $query->getQuery()->getResult();

    }

    /**
     * @param $field
     * @param $dateBegin
     * @param $dateEnd
     * @return mixed
     */
    public function getCountFieldBetween($field,$dateBegin, $dateEnd)
    {
        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:BillControl');

        $query = $repository->createQueryBuilder('c');


        $query
            ->select('c')
            //->join('c.billLine', 'billLine')
            //->join('billLine.bill', 'bill')
            ->where('c.enabled = 1')
            ->andWhere('c.receivedAt BETWEEN :begin AND :end')
            ->setParameter('begin', $dateBegin)
            ->setParameter('end', $dateEnd)
            //    ->groupBy(''.$field.'')
        ;

        return $query->getQuery()->getResult();

    }

    /**
     * @param $value
     * @param $dateBegin
     * @param $dateEnd
     * @return mixed
     */
    public function getCountBetweenVal($value,$dateBegin, $dateEnd)
    {
        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Bill');

        $query = $repository->createQueryBuilder('c');


        $query
            ->select('c')
            ->where('c.enabled = 1')
            ->andWhere('c.nsValue = :value')
            ->andWhere('c.receivedAt BETWEEN :begin AND :end')
            ->setParameter('begin', $dateBegin)
            ->setParameter('end', $dateEnd)
            ->setParameter('value', $value)
            //    ->groupBy(''.$field.'')
        ;

        return $query->getQuery()->getResult();

    }
}
