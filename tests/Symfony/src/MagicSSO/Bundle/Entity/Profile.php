<?php
namespace MagicSSO\Bundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * MagicSSO\Bundle\Entity\Profile
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Profile
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Random string tgt(Ticket Granting Ticket) as an auth active token.
     *
     * @ORM\Column(type="string")
     */
    protected $tgt;
    
    /**
     * @ORM\Column(name="tgt_expired", type="boolean")
     */
    protected $tgtExpired;
    
    /**
     * @ORM\Column(name="tgt_expires_at", type="datetime")
     */
    protected $tgtExpiresAt;

    /**
     * @ORM\OneToOne(targetEntity="User", mappedBy="profile")
     */
    private $user;

    // These profile can aquire from discuz
    //
    // realname
    // gender
    // birthyear
    // birthmonth
    // birthday
    // constellation
    // zodiac
    // telephone
    // mobile
    // idcardtype
    // idcard
    // address
    // zipcode
    // nationality
    // birthprovince
    // birthcity
    // birthdist
    // birthcommunity
    // resideprovince
    // residecity
    // residedist
    // residecommunity
    // residesuite
    // graduateschool
    // company
    // education
    // occupation
    // position
    // revenue
    // affectivestatus
    // lookingfor
    // bloodtype
    // height
    // weight
    // alipay
    // icq
    // qq
    // yahoo
    // msn
    // taobao
    // site
    // bio
    // interest

    public function __construct()
    {

    }

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
     * Set user
     *
     * @param MagicSSO\Bundle\Entity\User $user
     * @return Profile
     */
    public function setUser(\MagicSSO\Bundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return MagicSSO\Bundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set tgt
     *
     * @param string $tgt
     * @return Profile
     */
    public function setTgt($tgt)
    {
        $this->tgt = $tgt;
    
        return $this;
    }

    /**
     * Get tgt
     *
     * @return string 
     */
    public function getTgt()
    {
        return $this->tgt;
    }

    /**
     * Set tgtExpired
     *
     * @param boolean $tgtExpired
     * @return Profile
     */
    public function setTgtExpired($tgtExpired)
    {
        $this->tgtExpired = $tgtExpired;
    
        return $this;
    }

    /**
     * Get tgtExpired
     *
     * @return boolean 
     */
    public function getTgtExpired()
    {
        return $this->tgtExpired;
    }

    /**
     * Set tgtExpiresAt
     *
     * @param \DateTime $tgtExpiresAt
     * @return Profile
     */
    public function setTgtExpiresAt($tgtExpiresAt)
    {
        $this->tgtExpiresAt = $tgtExpiresAt;
    
        return $this;
    }

    /**
     * Get tgtExpiresAt
     *
     * @return \DateTime 
     */
    public function getTgtExpiresAt()
    {
        return $this->tgtExpiresAt;
    }
}