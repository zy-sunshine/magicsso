<?php

namespace MagicSSO\Bundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @ORM\OneToOne(targetEntity="Profile", inversedBy="user")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     */
    private $profile;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set profile
     *
     * @param MagicSSO\Bundle\Entity\Profile $profile
     * @return User
     */
    public function setProfile(\MagicSSO\Bundle\Entity\Profile $profile = null)
    {
        $this->profile = $profile;
    
        return $this;
    }

    /**
     * Get profile
     *
     * @return MagicSSO\Bundle\Entity\Profile 
     */
    public function getProfile()
    {
        return $this->profile;
    }
}