<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
/**
 * Class BillRepository
 *
 * @package AppBundle\EntityRepository
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class BillRepository extends EntityRepository
{
    /**
     * @param $line
     * @param $value
     * @param $dateBegin
     * @param $dateEnd
     * @return mixed
     */
    public function getCountBetweenVal($line, $value,$dateBegin, $dateEnd)
    {
        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Bill');

        $query = $repository->createQueryBuilder('c');


        $query
            ->select('c')
            ->leftjoin('c.client', 'client')
            ->leftjoin('c.vehicle', 'vehicle')
            ->join('c.status', 'status')
            ->where('c.enabled = 1')
            ->andWhere('c.fecha BETWEEN :begin AND :end')
            ->andWhere('status.name != :pend');
            if($line == 'client'){
                $query->andWhere('client.id = :value');
            }elseif($line == 'vehicle'){
                $query->andWhere('vehicle.id = :value');
            }
            //->andWhere('c.nsValue = :value')

            if($line) {
                $query
                    ->setParameter('value', $value);
            }
        $query
            ->setParameter('pend', "pendiente")
            ->setParameter('begin', $dateBegin)
            ->setParameter('end', $dateEnd)
            //    ->groupBy(''.$field.'')
        ;

            //dump($query->getQuery()->getResult());die();
        return $query->getQuery()->getResult();

    }

    /**
     * @param $dateBegin
     * @param $dateEnd
     * @return mixed
     */
    public function getCountBetweenWV($value,$dateBegin, $dateEnd)
    {
        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Bill');

        $query = $repository->createQueryBuilder('c');


        $query
            ->select('c.fecha AS day, COUNT(DISTINCT c.id) AS amount, c.nsValue')
            ->leftjoin('c.client', 'client')
            ->leftjoin('c.vehicle', 'vehicle')
            ->join('c.status', 'status')
            ->where('c.enabled = 1')
            ->andWhere('c.fecha BETWEEN :begin AND :end')
            ->andWhere('c.nsValue = :value')
            ->andWhere('status.name != :pend')
            ->groupBy('c.fecha')
        ;
        //->andWhere('c.nsValue = :value')

        $query
            ->setParameter('pend', "pendiente")
            ->setParameter('begin', $dateBegin)
            ->setParameter('end', $dateEnd)
            ->setParameter('value', $value)
            //    ->groupBy(''.$field.'')
        ;

        //dump($query->getQuery()->getResult());die();
        return $query->getQuery()->getResult();

    }

    /**
     * @param $dateBegin
     * @param $dateEnd
     * @return mixed
     */
    public function getCountBetween($dateBegin, $dateEnd)
    {
        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Bill');

        $query = $repository->createQueryBuilder('c');


        $query
            ->select('')
            ->leftjoin('c.client', 'client')
            ->leftjoin('c.vehicle', 'vehicle')
            ->join('c.status', 'status')
            ->where('c.enabled = 1')
            ->andWhere('c.fecha BETWEEN :begin AND :end')
            ->andWhere('status.name != :pend')
            ->groupBy('c.fecha')

        ;
        //->andWhere('c.nsValue = :value')

        $query
            ->setParameter('pend', "pendiente")
            ->setParameter('begin', $dateBegin)
            ->setParameter('end', $dateEnd)
            //    ->groupBy(''.$field.'')
        ;

        //dump($query->getQuery()->getResult());die();
        return $query->getQuery()->getResult();

    }

    public function getCounter()
    {
        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Bill');

        return $this->createQueryBuilder('b')
            ->select('client.nomAux, SUM(CASE WHEN bill.nsValue = 1 THEN 1 ELSE 0 END) as countOne, SUM(CASE WHEN bill.nsValue = 0 THEN 1 ELSE 0 END) as countZero')
            ->join('bill.client', 'client')
            ->leftjoin('bill.vehicle', 'vehicle')
            ->join('bill.status', 'status')
            ->groupBy('client.nomAux')
            ->orderBy('countOne', 'DESC')
            //->orderBy('countZero', 'DESC')
            //->andWhere('c.fecha BETWEEN :begin AND :end')
            ->andWhere('status.name != :pend')
            ->setParameter('pend', "pendiente")
            //->setParameter('begin', $dateBegin)
            //->setParameter('end', $dateEnd)
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    function getCounter2(){
        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Bill');

        $query = $repository->createQueryBuilder('c');


        $query
            ->select('c.fecha, SUM(CASE WHEN c.nsValue = 1 then 1 else null end) CountOne')
            ->leftjoin('c.client', 'client')
            ->leftjoin('c.vehicle', 'vehicle')
            ->join('c.status', 'status')
            //->leftjoin('vehicle.routes', 'route')
            ->where('c.enabled = 1')
            //->andWhere('c.fecha BETWEEN :begin AND :end')
            //->andWhere('status.name != :pend')
            ->groupBy('c.CountOne')

        ;


        dump($query->getQuery()->getResult());die();
        return $query->getQuery()->getResult();

    }

    public function getCounterWDateClient($dateBegin, $dateEnd, $results)
    {
        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Bill');
        $query = $repository->createQueryBuilder('b');
        $query
            ->select(' SUM(CASE WHEN bill.nsValue = 1 THEN 1 ELSE 0 END) as countOne, SUM(CASE WHEN bill.nsValue = 0 THEN 1 ELSE 0 END) as countZero,  SUM(CASE WHEN bill.nsValue = 1 THEN 1 ELSE  1 END) as countTotal,client.nomAux')
            ->join('bill.client', 'client')
            //->join('bill.status', 'status')
            ->groupBy('client')
            ->andWhere('bill.fecha BETWEEN :begin AND :end')
            ->andWhere('bill.nsValue IS NOT NULL')
            //->andWhere('status.name != :pend')
            //->setParameter('pend', "pendiente")
            ->setParameter('begin', $dateBegin)
            ->setParameter('end', $dateEnd);
        if($results === 'TOP'){
            $query->orderBy('countOne', 'DESC');
        }elseif($results === 'BOTTOM'){
            $query->orderBy('countOne', 'ASC');
        }
        return $query
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }


    public function getCounterWDateDispatch($dateBegin, $dateEnd, $results)
    {
        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Bill');
        $query = $repository->createQueryBuilder('b');
        $query
            ->select('dispatch.nomDch, SUM(CASE WHEN bill.nsValue = 1 THEN 1 ELSE 0 END) as countOne, SUM(CASE WHEN bill.nsValue = 0 THEN 1 ELSE 0 END) as countZero')
            ->innerJoin('bill.dispatch', 'dispatch')
            //->join('bill.status', 'status')
            ->groupBy('dispatch')
            ->andWhere('bill.createdAt BETWEEN :begin AND :end')
            //->andWhere('status.name != :pend')
            //->setParameter('pend', "pendiente")
            ->setParameter('begin', $dateBegin)
            ->setParameter('end', $dateEnd)

        ;
        /*
        if($results === 'TOP'){
            $query
                ->orderBy('countOne', 'DESC')
            ;
        }else{
            $query
                ->orderBy('countOne', 'ASC')
            ;
        }
*/
        $result =  $query
            //->setMaxResults(5)
            ->getQuery()
            ->getResult();

        var_dump($result);die();
    }

    public function getDetailDispatch($dateBegin, $dateEnd, $ceco, $results)
    {
        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Bill');
        $query = $repository->createQueryBuilder('b');
        $query
            ->select('b')
            ->join('bill.dispatch', 'dispatch')
            //->join('bill.status', 'status')
            ->groupBy('dispatch')
            ->andWhere('bill.fecha BETWEEN :begin AND :end')
            ->andWhere('dispatch.nomDch == :ceco')
            //->andWhere('status.name != :pend')
            //->setParameter('pend', "pendiente")
            ->setParameter('ceco', $ceco)
            ->setParameter('begin', $dateBegin)
            ->setParameter('end', $dateEnd)

        ;
        return $query
            ->getQuery()
            ->getResult();
    }

    public function newFunctionDql($dateBegin, $dateEnd, $ceco){

        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Bill');
        $query = $repository->createQueryBuilder('bill');
        $query
            ->select('dispatch.nomDch, SUM(CASE WHEN bill.nsValue = 1 THEN 1 ELSE 0 END) as countOne, SUM(CASE WHEN bill.nsValue = 0 THEN 1 ELSE 0 END) as countZero, SUM(CASE WHEN bill.nsValue = 1 THEN 1 ELSE 1 END) as countTotal')
            ->innerJoin('bill.dispatch', 'dispatch')
            //->join('bill.status', 'status')
            ->where('bill.receivedAt BETWEEN :inicio AND :fin')

            ->setParameter('inicio',new \DateTime($dateBegin))
            ->setParameter('fin',new \DateTime($dateEnd))
            ->groupBy('dispatch')
            ->orderBy('countTotal, countZero', 'ASC')
        ;
        $result = $query
            ->getQuery()
            ->getResult()
            //->getArrayResult()
        ;

        //dump($result);die();
        return $result;
    }

    public function newFunctionTotalDql($dateBegin, $dateEnd){

        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Bill');
        $query = $repository->createQueryBuilder('bill');
        $query
            ->select('SUM(CASE WHEN bill.nsValue = 1 THEN 1 ELSE 0 END) as countOne, SUM(CASE WHEN bill.nsValue = 0 THEN 1 ELSE 0 END) as countZero, SUM(CASE WHEN bill.nsValue = 1 THEN 1 ELSE 1 END) as countTotal')
            ->innerJoin('bill.dispatch', 'dispatch')
            //->join('bill.status', 'status')
            //->where('bill.fecha BETWEEN :inicio AND :fin')->setParameter('inicio',new \DateTime($dateBegin))->setParameter('fin',new \DateTime($dateEnd))
            //->groupBy('dispatch')
            ->orderBy('countTotal, countZero, countOne', 'ASC')
        ;
        $result = $query
            ->getQuery()
            ->getResult()
            //->getArrayResult()
        ;

        //dump($result);die();
        return $result;
    }

    public function newFunctionReportCecoDql($dateBegin, $dateEnd){

        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Bill');
        $query = $repository->createQueryBuilder('bill');
        $query
            ->select('dispatch.nomDch, SUM(CASE WHEN bill.nsValue = 1 THEN 1 ELSE 0 END) as countOne, SUM(CASE WHEN bill.nsValue = 0 THEN 1 ELSE 0 END) as countZero, SUM(CASE WHEN bill.nsValue = 1 THEN 1 ELSE 1 END) as countTotal')
            ->innerJoin('bill.dispatch', 'dispatch')
            ->Leftjoin('bill.status', 'status')
            ->where('bill.fecha BETWEEN :inicio AND :fin')->setParameter('inicio',new \DateTime($dateBegin))->setParameter('fin',new \DateTime($dateEnd))
            ->andWhere('status.name != :pend')
            ->setParameter('pend', "pendiente")

            ->groupBy('dispatch.nomDch')
            ->orderBy('countTotal, countZero', 'ASC')
        ;
        $result = $query
            ->getQuery()
            ->getResult()
            //->getArrayResult()
        ;

        //dump($result);die();
        return $result;
    }

    public function newFunctionReportClientDql($dateBegin, $dateEnd){

        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Bill');
        $query = $repository->createQueryBuilder('bill');
        $query
            ->select('client.nomAux, SUM(CASE WHEN bill.nsValue = 1 THEN 1 ELSE 0 END) as countOne, SUM(CASE WHEN bill.nsValue = 0 THEN 1 ELSE 0 END) as countZero, SUM(CASE WHEN bill.nsValue = 1 THEN 1 ELSE 1 END) as countTotal')
            ->innerJoin('bill.client', 'client')
            ->Leftjoin('bill.status', 'status')
            ->where('bill.fecha BETWEEN :inicio AND :fin')->setParameter('inicio',new \DateTime($dateBegin))->setParameter('fin',new \DateTime($dateEnd))
            ->andWhere('status.name != :pend')
            ->setParameter('pend', "pendiente")

            ->groupBy('client.nomAux')
            ->orderBy('countTotal, countZero', 'ASC')
        ;
        $result = $query
            ->getQuery()
            ->getResult()
            //->getArrayResult()
        ;

        //dump($result);die();
        return $result;
    }

    public function newFunctionReportPatentDql($dateBegin, $dateEnd){

        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Bill');
        $query = $repository->createQueryBuilder('bill');
        $query
            ->select('vehicle.patent, SUM(CASE WHEN bill.nsValue = 1 THEN 1 ELSE 0 END) as countOne, SUM(CASE WHEN bill.nsValue = 0 THEN 1 ELSE 0 END) as countZero, SUM(CASE WHEN bill.nsValue = 1 THEN 1 ELSE 1 END) as countTotal')
            ->innerJoin('bill.vehicle', 'vehicle')
            ->Leftjoin('bill.status', 'status')
            ->where('bill.fecha BETWEEN :inicio AND :fin')->setParameter('inicio',new \DateTime($dateBegin))->setParameter('fin',new \DateTime($dateEnd))
            ->andWhere('status.name != :pend')
            ->setParameter('pend', "pendiente")

            ->groupBy('vehicle.patent')
            ->orderBy('countTotal, countZero', 'ASC')
        ;
        $result = $query
            ->getQuery()
            ->getResult()
            //->getArrayResult()
        ;

        //dump($result);die();
        return $result;
    }

    public function newFunctionTotalDql2($dateBegin, $dateEnd){

        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Bill');
        $query = $repository->createQueryBuilder('bill');
        $query
            ->select('SUM(CASE WHEN bill.nsValue = 1 THEN 1 ELSE 0 END) as countOne, SUM(CASE WHEN bill.nsValue = 0 THEN 1 ELSE 0 END) as countZero, SUM(CASE WHEN bill.nsValue = 1 THEN 1 ELSE 1 END) as countTotal')
            ->innerJoin('bill.dispatch', 'dispatch')
            ->join('bill.status', 'status')
            ->where('bill.fecha BETWEEN :inicio AND :fin')->setParameter('inicio',new \DateTime($dateBegin))->setParameter('fin',new \DateTime($dateEnd))
            ->groupBy('dispatch')
            ->orderBy('countTotal, countZero, countOne', 'ASC')
        ;
        $result = $query
            ->getQuery()
            ->getResult()
            //->getArrayResult()
        ;

        //dump($result);die();
        return $result;
    }
}
