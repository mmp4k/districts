<?php
namespace mmp\rjpBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ElectionHasElectoralCommission
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
     * @ORM\Column(type="integer", length=11, nullable=true)
     */
    private $authorized;

    /**
     * @ORM\ManyToOne(targetEntity="mmp\rjpBundle\Entity\Election", inversedBy="electoralCommissions")
     * @ORM\JoinColumn(name="election_id", referencedColumnName="id")
     */
    private $election;

    /**
     * @ORM\ManyToOne(targetEntity="mmp\rjpBundle\Entity\ElectoralCommission", inversedBy="elections", fetch="EAGER")
     * @ORM\JoinColumn(name="electoral_commission_id", referencedColumnName="id")
     */
    private $electoralCommission;

    /**
     * @ORM\ManyToOne(targetEntity="mmp\rjpBundle\Entity\District")
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id")
     */
    private $district;

    /**
     * @ORM\ManyToMany(targetEntity="mmp\rjpBundle\Entity\HouseNumber", mappedBy="")
     */
    private $houseNumbersWithStreets;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->houseNumbersWithStreets = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set votes
     *
     * @param integer $votes
     * @return ElectionHasElectoralCommission
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;

        return $this;
    }

    /**
     * Get votes
     *
     * @return integer 
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * Set authorized
     *
     * @param integer $authorized
     * @return ElectionHasElectoralCommission
     */
    public function setAuthorized($authorized)
    {
        $this->authorized = $authorized;

        return $this;
    }

    /**
     * Get authorized
     *
     * @return integer 
     */
    public function getAuthorized()
    {
        return $this->authorized;
    }

    /**
     * Set election
     *
     * @param \mmp\rjpBundle\Entity\Election $election
     * @return ElectionHasElectoralCommission
     */
    public function setElection(\mmp\rjpBundle\Entity\Election $election = null)
    {
        $this->election = $election;

        return $this;
    }

    /**
     * Get election
     *
     * @return \mmp\rjpBundle\Entity\Election 
     */
    public function getElection()
    {
        return $this->election;
    }

    /**
     * Set electoralCommission
     *
     * @param \mmp\rjpBundle\Entity\ElectoralCommission $electoralCommission
     * @return ElectionHasElectoralCommission
     */
    public function setElectoralCommission(\mmp\rjpBundle\Entity\ElectoralCommission $electoralCommission = null)
    {
        $this->electoralCommission = $electoralCommission;

        return $this;
    }

    /**
     * Get electoralCommission
     *
     * @return \mmp\rjpBundle\Entity\ElectoralCommission 
     */
    public function getElectoralCommission()
    {
        return $this->electoralCommission;
    }

    /**
     * Set district
     *
     * @param \mmp\rjpBundle\Entity\District $district
     * @return ElectionHasElectoralCommission
     */
    public function setDistrict(\mmp\rjpBundle\Entity\District $district = null)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district
     *
     * @return \mmp\rjpBundle\Entity\District 
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Add houseNumbersWithStreets
     *
     * @param \mmp\rjpBundle\Entity\HouseNumber $houseNumbersWithStreets
     * @return ElectionHasElectoralCommission
     */
    public function addHouseNumbersWithStreet(\mmp\rjpBundle\Entity\HouseNumber $houseNumbersWithStreets)
    {
        $this->houseNumbersWithStreets[] = $houseNumbersWithStreets;

        return $this;
    }

    /**
     * Remove houseNumbersWithStreets
     *
     * @param \mmp\rjpBundle\Entity\HouseNumber $houseNumbersWithStreets
     */
    public function removeHouseNumbersWithStreet(\mmp\rjpBundle\Entity\HouseNumber $houseNumbersWithStreets)
    {
        $this->houseNumbersWithStreets->removeElement($houseNumbersWithStreets);
    }

    /**
     * Get houseNumbersWithStreets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHouseNumbersWithStreets()
    {
        return $this->houseNumbersWithStreets;
    }
}
