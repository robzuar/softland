<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Owner;

class LoadOwnerData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }

    /**
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $owner = [
           ['3F'],
            ['Cristian Silva'],
            ['Edgardo Zambrano'],
            ['Francisco Aliaga'],
            ['Juan Jara'],
            ['Miriam Peña'],
            ['MONTEROSA'],
            ['Raul Toro'],
            ['Rodrigo Fernandez'],
            ['SUAZO'],
            ['NN'],
            ['Edmundo Martinez'],
            ['Sergio Mena'],
            ['MONTEROSA'],
            ['Jose Masias'],
            ['RETIRO EN PLANTA']
        ];

        foreach ($owner as $statu) {
            $this->createOwner($manager, $statu);
        }
    }

    /**
     *
     * @param ObjectManager $manager
     * @param type $n
     */
    private function createOwner(ObjectManager $manager, $n)
    {
        $user = $manager->getRepository('AppBundle:Usuario')->findOneBy(['username' => 'roberto.zuniga.araya@gmail.com']);
        $owner = new Owner($user);
        $owner->setName($n[0]);

        $manager->persist($owner);
        $manager->flush();
    }
}