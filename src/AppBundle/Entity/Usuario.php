<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Usuario
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 * 
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class Usuario extends BaseUser
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN= 'ROLE_ADMIN';
    const ROLE_SUPER_ADMIN=  'ROLE_SUPER_ADMIN';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * Usuario constructor.
     * @param $valor
     */
    public function __construct()
    {
        parent::__construct();
        $this->username = 'username';
        $this->plainPassword = '123456';
        $this->setEnabled(true);
    }
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->firstName . " " .$this->lastName ;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param $firstName
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param $lastName
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultRole()
    {
        return self::ROLE_USER;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        $this->setUsername($email);

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function fullFirstName()
    {
        return $this->getFirstName()." ".$this->getLastname();
    }
}
