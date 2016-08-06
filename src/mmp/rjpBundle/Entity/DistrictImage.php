<?php

namespace mmp\rjpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="district_images", indexes={@ORM\Index(name="IndexDistrict", columns={"district_id"})})
 */
class DistrictImage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="mmp\rjpBundle\Entity\District", inversedBy="images")
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
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return DistrictImage
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get image.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set image.
     *
     * @param string $image
     *
     * @return DistrictImage
     */
    public function setImage($image)
    {
        $this->image = $image;

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
     * @return DistrictImage
     */
    public function setDistrict(\mmp\rjpBundle\Entity\District $district = null)
    {
        $this->district = $district;

        return $this;
    }
}
