<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class UsuarioRepository
 *
 * @package AppBundle\EntityRepository
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class UsuarioRepository extends EntityRepository
{
    /**
     * @param $role
     * @return mixed
     */
    public function getUserByRole($role)
    {
        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Usuario');

        $query = $repository->createQueryBuilder('c');


            $query
                ->select('c')
                ->where('c.roles like :role')
                ->setParameter('role', '%"'.$role.'"%');

            return $query->getQuery()->getResult();

    }
}
