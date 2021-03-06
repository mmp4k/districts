<?php

namespace mmp\rjpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="mmp\rjpBundle\Entity\Repository\ElectionRepository")
 */
class Election
{
    /**
     * @var mmp\rjpBundle\Library\Statistics\Election
     */
    protected $statistics;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=false)
     */
    private $date;
    /**
     * @ORM\OneToMany(targetEntity="mmp\rjpBundle\Entity\Candidate", mappedBy="election")
     */
    private $candidates;
    /**
     * @ORM\OneToMany(targetEntity="mmp\rjpBundle\Entity\ElectionHasElectoralCommission", mappedBy="election")
     */
    private $electoralCommissions;
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
     * Constructor.
     */
    public function __construct()
    {
        $this->candidates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->districts = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Election
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Add candidates.
     *
     * @param \mmp\rjpBundle\Entity\Candidate $candidates
     *
     * @return Election
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
        return $this->date->format('d.m.Y');
    }

    public function getCandidatesByDistrict(\mmp\rjpBundle\Entity\District $district)
    {
        $candidatesByDistrict = array();
        foreach ($this->getCandidates() as $candidate) {
            if ($candidate->getDistrict() == $district) {
                $candidatesByDistrict[] = $candidate;
            }
        }

        return new \Doctrine\Common\Collections\ArrayCollection($candidatesByDistrict);
    }

    /**
     * Add districts.
     *
     * @param \mmp\rjpBundle\Entity\District $districts
     *
     * @return Election
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
     * Get statistcs.
     *
     * @return mmp\rjpBundle\Library\Statistics\Election
     */
    public function getStatistics()
    {
        if ($this->statistics) {
            return $this->statistics;
        }

        $this->statistics = new \mmp\rjpBundle\Library\Statistics\Election($this);

        return $this->statistics;
    }

    /**
     * Add electoralCommissions.
     *
     * @param \mmp\rjpBundle\Entity\ElectionHasElectoralCommission $electoralCommissions
     *
     * @return Election
     */
    public function addElectoralCommission(\mmp\rjpBundle\Entity\ElectionHasElectoralCommission $electoralCommissions)
    {
        $this->electoralCommissions[] = $electoralCommissions;

        return $this;
    }

    /**
     * Remove electoralCommissions.
     *
     * @param \mmp\rjpBundle\Entity\ElectionHasElectoralCommission $electoralCommissions
     */
    public function removeElectoralCommission(\mmp\rjpBundle\Entity\ElectionHasElectoralCommission $electoralCommissions)
    {
        $this->electoralCommissions->removeElement($electoralCommissions);
    }

    /**
     * Get electoralCommissions.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getElectoralCommissions()
    {
        return $this->electoralCommissions;
    }
}
