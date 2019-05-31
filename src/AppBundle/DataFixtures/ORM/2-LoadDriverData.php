<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Driver;

class LoadDriverData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 100; $i++) {
            $this->createDriver($manager, $i);
        }
    }

    /**
     *
     * @param ObjectManager $manager
     * @param type $n
     */
    private function createDriver(ObjectManager $manager, $n)
    {
        $user = $manager->getRepository('AppBundle:Usuario')->findOneBy(['username' => 'roberto.zuniga.araya@gmail.com']);
        $driver = new Driver($user);
        $driver->setName('Driver ' . $n);

        $manager->persist($driver);
        $manager->flush();
    }
}