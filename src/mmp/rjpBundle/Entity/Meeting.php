<?php
namespace mmp\rjpBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

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
     * @ORM\ManyToOne(targetEntity="mmp\rjpBundle\Entity\User", inversedBy="meetings")
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
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
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
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
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
     * Get map_coords
     *
     * @return string 
     */
    public function getMapCoords()
    {
        return $this->map_coords;
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
     * Get link_facebook
     *
     * @return string 
     */
    public function getLinkFacebook()
    {
        return $this->link_facebook;
    }

    /**
     * Set organizer
     *
     * @param \mmp\rjpBundle\Entity\User $organizer
     * @return Meeting
     */
    public function setOrganizer(\mmp\rjpBundle\Entity\User $organizer = null)
    {
        $this->organizer = $organizer;

        return $this;
    }

    /**
     * Get organizer
     *
     * @return \mmp\rjpBundle\Entity\User 
     */
    public function getOrganizer()
    {
        return $this->organizer;
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

    /**
     * Get district
     *
     * @return \mmp\rjpBundle\Entity\District 
     */
    public function getDistrict()
    {
        return $this->district;
    }
}
