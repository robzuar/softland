<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Region;

/**
 * Class LoadRegionData
 * @package AppBundle\DataFixtures\ORM
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class LoadRegionData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * @return int
     */
    public function getOrder()
    {
        return 0;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $regions = $this->getRegions();

        foreach ($regions as $region) {
            $newRegion = new Region();
            $newRegion->setName($region['name']);
            $newRegion->setCode($region['code']);
            $manager->persist($newRegion);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    private function getRegions()
    {
        return [
            ['name' => 'Arica y Parinacota', 'code' => '15'],
            ['name' => 'Tarapacá', 'code' => '1'],
            ['name' => 'Antofagasta', 'code' => '2'],
            ['name' => 'Atacama', 'code' => '3'],
            ['name' => 'Coquimbo', 'code' => '4'],
            ['name' => 'Valparaiso', 'code' => '5'],
            ['name' => 'Metropolitana de Santiago', 'code' => '13'],
            ['name' => 'Libertador General Bernardo O\'Higgins', 'code' => '6'],
            ['name' => 'Ñuble', 'code' => '16'],
            ['name' => 'Maule', 'code' => '7'],
            ['name' => 'Concepción', 'code' => '8'],
            ['name' => 'La Araucanía', 'code' => '9'],
            ['name' => 'Los Ríos', 'code' => '14'],
            ['name' => 'Los Lagos', 'code' => '10'],
            ['name' => 'Aisén del General Carlos Ibáñez del Campo', 'code' => '11'],
            ['name' => 'Magallanes y de la Antártica Chilena', 'code' => '12'],
        ];
    }
}
