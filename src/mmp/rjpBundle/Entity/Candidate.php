<?php

namespace mmp\rjpBundle\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="mmp\rjpBundle\Entity\Repository\CandidateRepository")
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="UserIndex", columns={"user_id"}),
 *         @ORM\Index(name="DistrictIndex", columns={"district_id"}),
 *         @ORM\Index(name="ElectionIndex", columns={"election_id"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Candidate
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=11, nullable=true)
     */
    private $votes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $occupation;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $sex;

    /**
     * @ORM\Column(type="integer", length=11, nullable=true)
     */
    private $age;

    /**
     * @ORM\OneToOne(targetEntity="mmp\rjpBundle\Entity\Councilor", mappedBy="candidate")
     */
    private $councilor;

    /**
     * @ORM\JoinColumn(name="election_id", referencedColumnName="id", nullable=false)
     * @ORM\ManyToOne(targetEntity="mmp\rjpBundle\Entity\Election", inversedBy="candidates")
     */
    private $election;

    /**
     * @ORM\ManyToOne(targetEntity="mmp\rjpBundle\Entity\District", inversedBy="candidates")
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id", nullable=false)
     */
    private $district;

    /**
     * @ORM\ManyToOne(targetEntity="mmp\UserBundle\Entity\User", inversedBy="candidates", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    private $isCouncilor;

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
     * Get councilor.
     *
     * @return \mmp\rjpBundle\Entity\Councilor
     */
    public function getCouncilor()
    {
        return $this->councilor;
    }

    /**
     * Set councilor.
     *
     * @param \mmp\rjpBundle\Entity\Councilor $councilor
     *
     * @return Candidate
     */
    public function setCouncilor(\mmp\rjpBundle\Entity\Councilor $councilor = null)
    {
        $this->councilor = $councilor;

        return $this;
    }

    /**
     * Get election.
     *
     * @return \mmp\rjpBundle\Entity\Election
     */
    public function getElection()
    {
        return $this->election;
    }

    /**
     * Set election.
     *
     * @param \mmp\rjpBundle\Entity\Election $election
     *
     * @return Candidate
     */
    public function setElection(\mmp\rjpBundle\Entity\Election $election)
    {
        $this->election = $election;

        return $this;
    }

    /**
     * Get district.
     *
     * @return \mmp\rjpBundle\Entity\District
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set district.
     *
     * @param \mmp\rjpBundle\Entity\District $district
     *
     * @return Candidate
     */
    public function setDistrict(\mmp\rjpBundle\Entity\District $district)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \mmp\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user.
     *
     * @param \mmp\UserBundle\Entity\User $user
     *
     * @return Candidate
     */
    public function setUser(\mmp\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function isCouncilor()
    {
        return (bool) ($this->isCouncilor || ($this->councilor));
    }

    public function setIsCouncilor($value)
    {
        $this->isCouncilor = $value;

        return $this;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function appendCouncilorIfNeeded(LifecycleEventArgs $args)
    {
        if (!$this->isCouncilor) {
            return;
        }

        $em = $args->getEntityManager();

        $councilor = $this->getCouncilor() ? $this->getCouncilor() : new Councilor();
        $councilor->setCandidate($this);
        $councilor->setDistrict($this->getDistrict());

        $em->persist($councilor);
        $em->flush();
    }

    /**
     * Get votes.
     *
     * @return int
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * Set votes.
     *
     * @param int $votes
     *
     * @return Candidate
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;

        return $this;
    }

    /**
     * Get occupation.
     *
     * @return string
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * Set occupation.
     *
     * @param string $occupation
     *
     * @return Candidate
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;

        return $this;
    }

    /**
     * Get sex.
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set sex.
     *
     * @param string $sex
     *
     * @return Candidate
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get age.
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set age.
     *
     * @param int $age
     *
     * @return Candidate
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }
}
