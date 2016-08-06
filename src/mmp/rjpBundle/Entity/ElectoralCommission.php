<?php

namespace mmp\rjpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $point_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_url_min;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $point_street;

    /**
     * @ORM\OneToMany(
     *     targetEntity="mmp\rjpBundle\Entity\ElectionHasElectoralCommission",
     *     mappedBy="electoralCommission",
     *     cascade={"persist","remove"}
     * )
     */
    private $elections;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->elections = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return ElectoralCommission
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get point.
     *
     * @return string
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * Set point.
     *
     * @param string $point
     *
     * @return ElectoralCommission
     */
    public function setPoint($point)
    {
        $this->point = $point;

        return $this;
    }

    /**
     * Get polygon.
     *
     * @return string
     */
    public function getPolygon()
    {
        return $this->polygon;
    }

    /**
     * Set polygon.
     *
     * @param string $polygon
     *
     * @return ElectoralCommission
     */
    public function setPolygon($polygon)
    {
        $this->polygon = $polygon;

        return $this;
    }

    /**
     * Add elections.
     *
     * @param \mmp\rjpBundle\Entity\ElectionHasElectoralCommission $elections
     *
     * @return ElectoralCommission
     */
    public function addElection(\mmp\rjpBundle\Entity\ElectionHasElectoralCommission $elections)
    {
        $this->elections[] = $elections;

        return $this;
    }

    /**
     * Remove elections.
     *
     * @param \mmp\rjpBundle\Entity\ElectionHasElectoralCommission $elections
     */
    public function removeElection(\mmp\rjpBundle\Entity\ElectionHasElectoralCommission $elections)
    {
        $this->elections->removeElement($elections);
    }

    /**
     * Get elections.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getElections()
    {
        return $this->elections;
    }

    /**
     * Get point_name.
     *
     * @return string
     */
    public function getPointName()
    {
        return $this->point_name;
    }

    /**
     * Set point_name.
     *
     * @param string $pointName
     *
     * @return ElectoralCommission
     */
    public function setPointName($pointName)
    {
        $this->point_name = $pointName;

        return $this;
    }

    /**
     * Get point_street.
     *
     * @return string
     */
    public function getPointStreet()
    {
        return $this->point_street;
    }

    /**
     * Set point_street.
     *
     * @param string $pointStreet
     *
     * @return ElectoralCommission
     */
    public function setPointStreet($pointStreet)
    {
        $this->point_street = $pointStreet;

        return $this;
    }

    public function getPolygonArray()
    {
        $polygonArray = array();
        foreach (preg_split('/\n|\s/', $this->getPolygon()) as $pointLine) {
            if (!trim($pointLine)) {
                continue;
            }
            list($lat, $lng) = explode(',', $pointLine);
            $polygonArray[] = [
                'lat' => $lat,
                'lng' => $lng,
            ];
        }

        return $polygonArray;
    }

    /**
     * Get image_url_min.
     *
     * @return string
     */
    public function getImageUrlMin()
    {
        return $this->image_url_min;
    }

    /**
     * Set image_url_min.
     *
     * @param string $imageUrlMin
     *
     * @return ElectoralCommission
     */
    public function setImageUrlMin($imageUrlMin)
    {
        $this->image_url_min = $imageUrlMin;

        return $this;
    }

    /**
     * Get image_url.
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }

    /**
     * Set image_url.
     *
     * @param string $imageUrl
     *
     * @return ElectoralCommission
     */
    public function setImageUrl($imageUrl)
    {
        $this->image_url = $imageUrl;

        return $this;
    }
}
