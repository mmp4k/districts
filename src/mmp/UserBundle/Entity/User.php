<?php

namespace mmp\UserBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use mmp\MeetingBundle\Entity\Meeting;
use mmp\rjpBundle\Entity\Candidate;
use mmp\rjpBundle\Entity\District;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @var Collection|District[]
     *
     * @ORM\OneToMany(targetEntity="mmp\rjpBundle\Entity\District", mappedBy="coordinator")
     */
    protected $districts;

    /**
     * @var Collection|Meeting[]
     *
     * @ORM\OneToMany(targetEntity="mmp\MeetingBundle\Entity\Meeting", mappedBy="organizer")
     */
    protected $meetings;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $first_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $last_name;

    /**
     * @ORM\Column(type="integer", length=11, nullable=true)
     */
    protected $phone;

    /**
     * @var Collection|Candidate
     *
     * @ORM\OneToMany(targetEntity="mmp\rjpBundle\Entity\Candidate", mappedBy="user")
     */
    private $candidates;

    /** /Helpers **/
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add districts.
     *
     * @param \mmp\rjpBundle\Entity\District $districts
     *
     * @return User
     */
    public function addDistrict(\mmp\rjpBundle\Entity\District $districts)
    {
        $this->districts[] = $districts;

        return $this;
    }

    /**
     * Remove districts.
     *
     * @param \mmp\rjpBundle\Entity\District $districts
     */
    public function removeDistrict(\mmp\rjpBundle\Entity\District $districts)
    {
        $this->districts->removeElement($districts);
    }

    /**
     * Get districts.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDistricts()
    {
        return $this->districts;
    }

    /**
     * Add meetings.
     *
     * @param \mmp\MeetingBundle\Entity\Meeting $meetings
     *
     * @return User
     */
    public function addMeeting(\mmp\MeetingBundle\Entity\Meeting $meetings)
    {
        $this->meetings[] = $meetings;

        return $this;
    }

    /**
     * Remove meetings.
     *
     * @param \mmp\MeetingBundle\Entity\Meeting $meetings
     */
    public function removeMeeting(\mmp\MeetingBundle\Entity\Meeting $meetings)
    {
        $this->meetings->removeElement($meetings);
    }

    /**
     * Get meetings.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMeetings()
    {
        return $this->meetings;
    }

    // /**
    //  * Set councilor
    //  *
    //  * @param \mmp\rjpBundle\Entity\Councilor $councilor
    //  * @return User
    //  */
    // public function setCouncilor(\mmp\rjpBundle\Entity\Councilor $councilor = null)
    // {
    //     $this->councilor = $councilor;

    //     return $this;
    // }

    // /**
    //  * Get councilor
    //  *
    //  * @return \mmp\rjpBundle\Entity\Councilor
    //  */
    // public function getCouncilor()
    // {
    //     return $this->councilor;
    // }

    /**
     * Get first_name.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set first_name.
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get last_name.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set last_name.
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set phone.
     *
     * @param int $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Add candidates.
     *
     * @param \mmp\rjpBundle\Entity\Candidate $candidates
     *
     * @return User
     */
    public function addCandidate(\mmp\rjpBundle\Entity\Candidate $candidates)
    {
        $this->candidates[] = $candidates;

        return $this;
    }

    /**
     * Remove candidates.
     *
     * @param \mmp\rjpBundle\Entity\Candidate $candidates
     */
    public function removeCandidate(\mmp\rjpBundle\Entity\Candidate $candidates)
    {
        $this->candidates->removeElement($candidates);
    }

    /**
     * Get candidates.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCandidates()
    {
        return $this->candidates;
    }

    public function __toString()
    {
        return $this->getLastName() . ' ' . $this->getFirstName();
    }
}
