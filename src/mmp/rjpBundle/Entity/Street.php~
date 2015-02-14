<?php
namespace mmp\rjpBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Street
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="mmp\rjpBundle\Entity\HouseNumber", mappedBy="street")
     */
    private $houseNumbers;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->houseNumbers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Street
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add houseNumbers
     *
     * @param \mmp\rjpBundle\Entity\HouseNumber $houseNumbers
     * @return Street
     */
    public function addHouseNumber(\mmp\rjpBundle\Entity\HouseNumber $houseNumbers)
    {
        $this->houseNumbers[] = $houseNumbers;

        return $this;
    }

    /**
     * Remove houseNumbers
     *
     * @param \mmp\rjpBundle\Entity\HouseNumber $houseNumbers
     */
    public function removeHouseNumber(\mmp\rjpBundle\Entity\HouseNumber $houseNumbers)
    {
        $this->houseNumbers->removeElement($houseNumbers);
    }

    /**
     * Get houseNumbers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHouseNumbers()
    {
        return $this->houseNumbers;
    }
}
