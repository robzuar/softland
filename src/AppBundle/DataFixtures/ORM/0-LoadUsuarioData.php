<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Usuario;

/**
 * Class UsuarioLoadData
 * @package AppBundle\DataFixtures\ORM
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class LoadUsuarioData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        /** @var Usuario $usuario1 */
        $usuario1111 = $userManager->createUser();

        $usuario1111->setUsername('roberto.zuniga.araya@gmail.com');
        $usuario1111->setFirstName('Roberto Alfredo');
        $usuario1111->setLastName('Zuñiga Araya');
        $usuario1111->setEmail('roberto.zuniga.araya@gmail.com');
        $usuario1111->setPlainPassword('123456');
        $usuario1111->setEnabled(true);
        $usuario1111->setRoles(array('ROLE_SUPER_ADMIN'));
        $userManager->updateUser($usuario1111, true);

        $this->addReference('usuario1111', $usuario1111);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 0;
    }
}
