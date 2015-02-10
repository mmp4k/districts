<?php
namespace mmp\rjpBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class ElectoralCommission
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
     * 
     */
    private $streets;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $point;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $polygon;

    /**
     * @ORM\OneToMany(
     *     targetEntity="mmp\rjpBundle\Entity\ElectionHasElectoralCommission",
     *     mappedBy="electoralCommission"
     * )
     */
    private $elections;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->elections = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return ElectoralCommission
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
     * Set point
     *
     * @param string $point
     * @return ElectoralCommission
     */
    public function setPoint($point)
    {
        $this->point = $point;

        return $this;
    }

    /**
     * Get point
     *
     * @return string 
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * Set polygon
     *
     * @param string $polygon
     * @return ElectoralCommission
     */
    public function setPolygon($polygon)
    {
        $this->polygon = $polygon;

        return $this;
    }

    /**
     * Get polygon
     *
     * @return string 
     */
    public function getPolygon()
    {
        return $this->polygon;
    }

    /**
     * Add elections
     *
     * @param \mmp\rjpBundle\Entity\ElectionHasElectoralCommission $elections
     * @return ElectoralCommission
     */
    public function addElection(\mmp\rjpBundle\Entity\ElectionHasElectoralCommission $elections)
    {
        $this->elections[] = $elections;

        return $this;
    }

    /**
     * Remove elections
     *
     * @param \mmp\rjpBundle\Entity\ElectionHasElectoralCommission $elections
     */
    public function removeElection(\mmp\rjpBundle\Entity\ElectionHasElectoralCommission $elections)
    {
        $this->elections->removeElement($elections);
    }

    /**
     * Get elections
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getElections()
    {
        return $this->elections;
    }
}
