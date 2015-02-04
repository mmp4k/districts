<?php
namespace mmp\rjpBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity(repositoryClass="mmp\rjpBundle\Entity\Repository\ElectionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Election
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="mmp\rjpBundle\Entity\Candidate", mappedBy="election")
     */
    private $candidates;

    /**
     * @ORM\ManyToMany(targetEntity="mmp\rjpBundle\Entity\District", inversedBy="elections")
     * @ORM\JoinTable(
     *     name="DistrictHasElection",
     *     joinColumns={@ORM\JoinColumn(name="election_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="district_id", referencedColumnName="id", nullable=false)}
     * )
     */

    private $districts;    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->candidates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->districts = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     * @return Election
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add candidates
     *
     * @param \mmp\rjpBundle\Entity\Candidate $candidates
     * @return Election
     */
    public function addCandidate(\mmp\rjpBundle\Entity\Candidate $candidates)
    {
        $this->candidates[] = $candidates;

        return $this;
    }

    /**
     * Remove candidates
     *
     * @param \mmp\rjpBundle\Entity\Candidate $candidates
     */
    public function removeCandidate(\mmp\rjpBundle\Entity\Candidate $candidates)
    {
        $this->candidates->removeElement($candidates);
    }

    /**
     * Get candidates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCandidates()
    {
        return $this->candidates;
    }

    public function __toString() {
        return $this->date->format('d.m.Y');
    }

    public function getCandidatesByDistrict(\mmp\rjpBundle\Entity\District $district) {
        $candidatesByDistrict = array();
        foreach($this->getCandidates() as $candidate) {
            if($candidate->getDistrict() == $district) {
                $candidatesByDistrict[] = $candidate;
            }
        }

        return new \Doctrine\Common\Collections\ArrayCollection($candidatesByDistrict);
    }

    /**
     * Add districts
     *
     * @param \mmp\rjpBundle\Entity\District $districts
     * @return Election
     */
    public function addDistrict(\mmp\rjpBundle\Entity\District $districts)
    {
        $this->districts[] = $districts;

        return $this;
    }

    /**
     * Remove districts
     *
     * @param \mmp\rjpBundle\Entity\District $districts
     */
    public function removeDistrict(\mmp\rjpBundle\Entity\District $districts)
    {
        $this->districts->removeElement($districts);
    }

    /**
     * Get districts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDistricts()
    {
        return $this->districts;
    }
}
