<?php

namespace mmp\rjpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class HouseNumber
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="mmp\rjpBundle\Entity\Street", inversedBy="houseNumbers", cascade={"persist"})
     * @ORM\JoinColumn(name="street_id", referencedColumnName="id")
     */
    private $street;

    /**
     * @ORM\ManyToOne(targetEntity="mmp\rjpBundle\Entity\District", inversedBy="houseNumbersWithStreets")
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
     * Get number.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set number.
     *
     * @param string $number
     *
     * @return HouseNumber
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get street.
     *
     * @return \mmp\rjpBundle\Entity\Street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set street.
     *
     * @param \mmp\rjpBundle\Entity\Street $street
     *
     * @return HouseNumber
     */
    public function setStreet(\mmp\rjpBundle\Entity\Street $street = null)
    {
        $this->street = $street;

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
     * @return HouseNumber
     */
    public function setDistrict(\mmp\rjpBundle\Entity\District $district = null)
    {
        $this->district = $district;

        return $this;
    }

    public function __toString()
    {
        return $this->getStreet()->getName() . ' ' . $this->getNumber();
    }
}
