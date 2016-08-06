<?php

namespace mmp\rjpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(indexes={@ORM\Index(name="User2District", columns={"district_id"})})
 */
class Councilor
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="mmp\rjpBundle\Entity\Candidate", inversedBy="councilor")
     * @ORM\JoinColumn(name="candidate_id", referencedColumnName="id", nullable=false, unique=true, onDelete="CASCADE")
     */
    private $candidate;

    /**
     * @ORM\ManyToOne(targetEntity="mmp\rjpBundle\Entity\District", inversedBy="councilors")
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id")
     */
    private $district;

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
     * @return Councilor
     */
    public function setDistrict(\mmp\rjpBundle\Entity\District $district = null)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get candidate.
     *
     * @return \mmp\rjpBundle\Entity\Candidate
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * Set candidate.
     *
     * @param \mmp\rjpBundle\Entity\Candidate $candidate
     *
     * @return Councilor
     */
    public function setCandidate(\mmp\rjpBundle\Entity\Candidate $candidate)
    {
        $this->candidate = $candidate;

        return $this;
    }
}
