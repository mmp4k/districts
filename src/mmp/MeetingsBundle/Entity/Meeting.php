<?php

namespace mmp\MeetingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="IndexDistrict", columns={"district_id"}),
 *         @ORM\Index(name="IndexOrganizer", columns={"organizer_id"}),
 *         @ORM\Index(name="IndexDate", columns={"date"})
 *     }
 * )
 */
class Meeting
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $place;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $map_coords;

    /**
     * @ORM\ManyToOne(targetEntity="mmp\UserBundle\Entity\User", inversedBy="meetings")
     * @ORM\JoinColumn(name="organizer_id", referencedColumnName="id")
     */
    private $organizer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link_facebook;

    /**
     * @ORM\ManyToOne(targetEntity="mmp\rjpBundle\Entity\District", inversedBy="meetings")
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id")
     */
    private $district;

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
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Meeting
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set place
     *
     * @param string $place
     * @return Meeting
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get map_coords
     *
     * @return string
     */
    public function getMapCoords()
    {
        return $this->map_coords;
    }

    /**
     * Set map_coords
     *
     * @param string $mapCoords
     * @return Meeting
     */
    public function setMapCoords($mapCoords)
    {
        $this->map_coords = $mapCoords;

        return $this;
    }

    /**
     * Get link_facebook
     *
     * @return string
     */
    public function getLinkFacebook()
    {
        return $this->link_facebook;
    }

    /**
     * Set link_facebook
     *
     * @param string $linkFacebook
     * @return Meeting
     */
    public function setLinkFacebook($linkFacebook)
    {
        $this->link_facebook = $linkFacebook;

        return $this;
    }

    /**
     * Get organizer
     *
     * @return \mmp\UserBundle\Entity\User
     */
    public function getOrganizer()
    {
        return $this->organizer;
    }

    /**
     * Set organizer
     *
     * @param \mmp\UserBundle\Entity\User $organizer
     * @return Meeting
     */
    public function setOrganizer(\mmp\UserBundle\Entity\User $organizer = null)
    {
        $this->organizer = $organizer;

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
     * Set district
     *
     * @param \mmp\rjpBundle\Entity\District $district
     * @return Meeting
     */
    public function setDistrict(\mmp\rjpBundle\Entity\District $district = null)
    {
        $this->district = $district;

        return $this;
    }
}
