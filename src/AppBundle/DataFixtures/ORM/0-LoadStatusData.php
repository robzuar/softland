<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Status;

class LoadStatusData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @return int
     */
    public function getOrder()
    {
        return 0;
    }

    /**
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $status = [
            ['completado', 'Completado'],
            ['compobs', 'Completado con Observaciones'],
            ['compre', 'Completado con Reclamo'],
            ['compreobs','Completado con Observaciones y Reclamo'],
            ['pendiente', 'Pendiente'],
            ['gestreclamo', 'Gestión de Reclamo'],
            ['revision', 'Revisión'],
            ['parcial', 'Parcial'],
            ['reclamo', 'Reclamo']
        ];

        foreach ($status as $statu) {
            $this->createStatus($manager, $statu);
        }
    }

    /**
     *
     * @param ObjectManager $manager
     * @param type $n
     */
    private function createStatus(ObjectManager $manager, $n)
    {
        $user = $manager->getRepository('AppBundle:Usuario')->findOneBy(['username' => 'roberto.zuniga.araya@gmail.com']);
        $status = new Status($user);
        $status->setName($n[0]);
        $status->setDescription($n[1]);

        $manager->persist($status);
        $manager->flush();
    }
}