<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Vehicle;

class LoadVehicleData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @return int
     */
    public function getOrder()
    {
        return 6;
    }

    /**
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $vehicle = [
            ['3F', 'HRRH71'],
            ['3F','JKDG34'],
            ['Cristian Silva', 'WR7783'],
            ['Edgardo Zambrano', 'FSBV29'],
            ['Edgardo Zambrano','FYVS88'],
            ['Edgardo Zambrano','GHFW77'],
            ['Edgardo Zambrano','GJGD23'],
            ['Edgardo Zambrano','GPLS97'],
            ['Edgardo Zambrano','HCJL65'],
            ['Edgardo Zambrano','JKSK42'],
            ['Edgardo Zambrano','JKWP36'],
            ['Edmundo Martinez','YK4861'],
            ['Francisco Aliaga','BPZW95'],
            ['Juan Jara','GFTB30'],
            ['Miriam Peña','FPFY93'],
            ['Miriam Peña','HRRH71'],
            ['Miriam Peña','HWRF25'],
            ['Miriam Peña','JYGB67'],
            ['MONTEROSA','HRRH71'],
            ['MONTEROSA','JKDG34'],
            ['MONTEROSA','JYGB67'],
            ['Raul Toro','WV4029'],
            ['Rodrigo Fernandez','FPSV65'],
            ['SUAZO','JKDG34'],
            ['SUAZO','JYGB67'],
            ['SUAZO','HRRH71'],
            ['SUAZO','LSNGLS4'],
            ['Sergio Mena','CTBB81'],
            ['MONTEROSA','CHLLN3'],
            ['MONTEROSA','CRNL1'],
            ['MONTEROSA','CHLLN3'],
            ['MONTEROSA','TLCHN2'],
            ['Jose Masias','HPGK80'],
            ['NN', 'NN'],
            ['RETIRO EN PLANTA','RP']
        ];

        foreach ($vehicle as $statu) {
            $this->createVehicle($manager, $statu);
        }
    }

    /**
     *
     * @param ObjectManager $manager
     * @param type $n
     */
    private function createVehicle(ObjectManager $manager, $n)
    {
        $user = $manager->getRepository('AppBundle:Usuario')->findOneBy(['username' => 'roberto.zuniga.araya@gmail.com']);
        $vehicle = new Vehicle($user);
        $vehicle->setOwner($this->getOwner($manager,$n[0]));
        $vehicle->setPatent($n[1]);

        $manager->persist($vehicle);
        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param $name
     * @return Owner
     */
    public function getOwner(ObjectManager $manager, $name)
    {
        return $manager->getRepository('AppBundle:Owner')->findOneBy(['name' => $name]);
    }
}