<?php
namespace mmp\rjpBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use mmp\MeetingBundle\Entity\Meeting;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 
 * @ORM\Table(
 *     indexes={@ORM\Index(name="CoordinatorIndex", columns={"coordinator_id"})},
 *     uniqueConstraints={@ORM\UniqueConstraint(name="SlugIndex", columns={"slug"})}
 * )
 * 
 * @ORM\Entity(repositoryClass="mmp\rjpBundle\Entity\Repository\DistrictRepository")
 * @ORM\HasLifecycleCallbacks
 */
class District
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="integer", length=11, nullable=true)
     */
    private $signature_needed;

    /**
     * @ORM\Column(type="integer", length=11, nullable=true)
     */
    private $signature_gained;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)     
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link_facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link_poster;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link_template;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rjp_street;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rjp_name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $facebook_box;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link_kml;

    /**
     * @ORM\OneToMany(targetEntity="mmp\MeetingBundle\Entity\Meeting", mappedBy="district")
     * @ORM\OrderBy({"date"="ASC"})
     */
    private $meetings;

    /**
     * @ORM\OneToMany(targetEntity="mmp\rjpBundle\Entity\HouseNumber", mappedBy="district", cascade={"persist"})
     * @ORM\OrderBy({"street"="ASC","number"="ASC"})
     */
    private $houseNumbersWithStreets;

    /**
     * @ORM\OneToMany(targetEntity="mmp\rjpBundle\Entity\Councilor", mappedBy="district")
     */
    private $councilors;

    /**
     * @ORM\OneToMany(targetEntity="mmp\rjpBundle\Entity\Candidate", mappedBy="district")
     */
    private $candidates;

    /**
     * @ORM\OneToMany(targetEntity="mmp\rjpBundle\Entity\DistrictImage", mappedBy="district")
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="mmp\UserBundle\Entity\User", inversedBy="districts")
     * @ORM\JoinColumn(name="coordinator_id", referencedColumnName="id")
     */
    private $coordinator;

    /**
     * Elections
     * @ORM\ManyToMany(targetEntity="mmp\rjpBundle\Entity\Election", mappedBy="districts")
     * @ORM\OrderBy({"date"="desc"})
     */
    private $elections;

    /**
     * Vars for handle import files with streets
     */
    private $streetsXmlFile;

    private $candidatesOnElection;

    private $file;
    private $temp;
    private $statsOnElection;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->meetings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->councilors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->elections = new \Doctrine\Common\Collections\ArrayCollection();
        $this->candidatesOnElection = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() {
        return $this->getName();
    }

    /**
     * @ORM\PostLoad
     */
    public function init() {
        $this->candidatesOnElection = new \Doctrine\Common\Collections\ArrayCollection();;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $this->avatar = filter_var($this->getName(), FILTER_SANITIZE_URL) .'.'.$this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->avatar);

        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ($file && file_exists($file)) {
            unlink($file);
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->avatar ? null : $this->getUploadRootDir().'/'.$this->avatar;
    }

    public function getWebPath()
    {
        return null === $this->avatar ? null : $this->getUploadDir().'/'.$this->avatar;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->avatar)) {
            // store the old name to delete after the update
            $this->temp = $this->avatar;
            $this->avatar = null;
        } else {
            $this->avatar = 'initial';
        }
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
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return District
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

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
     * Set name
     *
     * @param string $name
     * @return District
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return District
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get signature_needed
     *
     * @return integer
     */
    public function getSignatureNeeded()
    {
        return $this->signature_needed;
    }

    /**
     * Set signature_needed
     *
     * @param integer $signatureNeeded
     * @return District
     */
    public function setSignatureNeeded($signatureNeeded)
    {
        $this->signature_needed = $signatureNeeded;

        return $this;
    }

    /**
     * Get signature_gained
     *
     * @return integer
     */
    public function getSignatureGained()
    {
        return $this->signature_gained;
    }

    /**
     * Set signature_gained
     *
     * @param integer $signatureGained
     * @return District
     */
    public function setSignatureGained($signatureGained)
    {
        $this->signature_gained = $signatureGained;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return District
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

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
     * @return District
     */
    public function setLinkFacebook($linkFacebook)
    {
        $this->link_facebook = $linkFacebook;

        return $this;
    }

    /**
     * Get link_poster
     *
     * @return string
     */
    public function getLinkPoster()
    {
        return $this->link_poster;
    }

    /**
     * Set link_poster
     *
     * @param string $linkPoster
     * @return District
     */
    public function setLinkPoster($linkPoster)
    {
        $this->link_poster = $linkPoster;

        return $this;
    }

    /**
     * Get link_template
     *
     * @return string
     */
    public function getLinkTemplate()
    {
        return $this->link_template;
    }

    /**
     * Set link_template
     *
     * @param string $linkTemplate
     * @return District
     */
    public function setLinkTemplate($linkTemplate)
    {
        $this->link_template = $linkTemplate;

        return $this;
    }

    /**
     * Add meetings
     *
     * @param Meeting $meeting
     * @return District
     */
    public function addMeeting(Meeting $meeting)
    {
        $this->meetings[] = $meeting;

        return $this;
    }

    /**
     * Remove meetings
     *
     * @param Meeting $meeting
     */
    public function removeMeeting(Meeting $meeting)
    {
        $this->meetings->removeElement($meeting);
    }

    /**
     * Get meetings
     *
     * @return Collection|Meeting[]
     */
    public function getMeetings()
    {
        return $this->meetings;
    }

    /**
     * Add councilors
     *
     * @param \mmp\rjpBundle\Entity\Councilor $councilors
     * @return District
     */
    public function addCouncilor(\mmp\rjpBundle\Entity\Councilor $councilors)
    {
        $this->councilors[] = $councilors;

        return $this;
    }

    /**
     * Remove councilors
     *
     * @param \mmp\rjpBundle\Entity\Councilor $councilors
     */
    public function removeCouncilor(\mmp\rjpBundle\Entity\Councilor $councilors)
    {
        $this->councilors->removeElement($councilors);
    }

    /**
     * Get councilors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCouncilors()
    {
        return $this->councilors;
    }

    /**
     * Add images
     *
     * @param \mmp\rjpBundle\Entity\DistrictImage $images
     * @return District
     */
    public function addImage(\mmp\rjpBundle\Entity\DistrictImage $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \mmp\rjpBundle\Entity\DistrictImage $images
     */
    public function removeImage(\mmp\rjpBundle\Entity\DistrictImage $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Get coordinator
     *
     * @return \mmp\UserBundle\Entity\User
     */
    public function getCoordinator()
    {
        return $this->coordinator;
    }

    /**
     * Set coordinator
     *
     * @param \mmp\UserBundle\Entity\User $coordinator
     * @return District
     */
    public function setCoordinator(\mmp\UserBundle\Entity\User $coordinator = null)
    {
        $this->coordinator = $coordinator;

        return $this;
    }

    public function statusIsExists() {
        return $this->status == 'exists';
    }

    public function statusIsInOffice() {
        return $this->status == 'in_office';
    }

    public function statusIsNeedCoordinator() {
        return $this->status == 'need_coordinator';
    }

    public function statusIsCollecting() {
        return $this->status == 'collecting';
    }

    public function statusIsElections() {
        return $this->status == 'elections';
    }

    /**
     * Add candidates
     *
     * @param \mmp\rjpBundle\Entity\Candidate $candidates
     * @return District
     */
    public function addCandidate(\mmp\rjpBundle\Entity\Candidate $candidates)
    {
        $this->candidates[] = $candidates;

        return $this;
    }

    /**
     * Remove candidates
     *
     * @param \mmp\rjpBundle\Entity\Candidate $candidates
     */
    public function removeCandidate(\mmp\rjpBundle\Entity\Candidate $candidates)
    {
        $this->candidates->removeElement($candidates);
    }

    /**
     * Get candidates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCandidates()
    {
        return $this->candidates;
    }

    /**
     * Set candidates
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $candidates
     * @return District
     */
    public function setCandidates(\Doctrine\Common\Collections\ArrayCollection $candidates)
    {
        $this->candidates = $candidates;

        return $this;
    }

    /**
     * Get rjp_street
     *
     * @return string
     */
    public function getRjpStreet()
    {
        return $this->rjp_street;
    }

    /**
     * Set rjp_street
     *
     * @param string $rjpStreet
     * @return District
     */
    public function setRjpStreet($rjpStreet)
    {
        $this->rjp_street = $rjpStreet;

        return $this;
    }

    /**
     * Get rjp_name
     *
     * @return string
     */
    public function getRjpName()
    {
        return $this->rjp_name;
    }

    /**
     * Set rjp_name
     *
     * @param string $rjpName
     * @return District
     */
    public function setRjpName($rjpName)
    {
        $this->rjp_name = $rjpName;

        return $this;
    }

    /**
     * Get facebook_box
     *
     * @return string
     */
    public function getFacebookBox()
    {
        return $this->facebook_box;
    }

    /**
     * Set facebook_box
     *
     * @param string $facebookBox
     * @return District
     */
    public function setFacebookBox($facebookBox)
    {
        $this->facebook_box = $facebookBox;

        return $this;
    }

    /**
     * Get link_kml
     *
     * @return string
     */
    public function getLinkKml()
    {
        return $this->link_kml;
    }

    /**
     * Set link_kml
     *
     * @param string $linkKml
     * @return District
     */
    public function setLinkKml($linkKml)
    {
        $this->link_kml = $linkKml;

        return $this;
    }

    /**
     * Add election
     *
     * @param \mmp\rjpBundle\Entity\Election $elections
     * @return District
     */
    public function addElection(\mmp\rjpBundle\Entity\Election $elections)
    {
        $this->elections[] = $elections;

        return $this;
    }

    /**
     * Remove election
     *
     * @param \mmp\rjpBundle\Entity\Election $elections
     */
    public function removeElection(\mmp\rjpBundle\Entity\Councilor $elections)
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

    /**
     * Set election
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $elections
     * @return District
     */
    public function setElections(\Doctrine\Common\Collections\ArrayCollection $elections)
    {
        $this->elections = $elections;

        return $this;
    }

    /**
     * Add candidates
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $candidates
     * @param \mmp\rjpBundle\Entity\Election $election
     * @return District
     */
    public function addCandidatesOnElection(\Doctrine\Common\Collections\ArrayCollection $candidates, \mmp\rjpBundle\Entity\Election $election)
    {
        if(!$this->getCandidatesOnElection($election)) {
            $this->candidatesOnElection->set($election->getId(), $candidates);
        }

        return $this;
    }

    /**
     * Get candidates on election
     *
     * @param \mmp\rjpBundle\Entity\Election $election
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCandidatesOnElection(\mmp\rjpBundle\Entity\Election $election)
    {
        return $this->candidatesOnElection->get($election->getId());
    }

    /**
     * Get statistics from election-district
     * @param \mmp\rjpBundle\Entity\Election $election
     * @return \mmp\rjpBundle\Library\Statistics\ElectionDistrict
     */
    public function getStatsOnElection(\mmp\rjpBundle\Entity\Election $election)
    {
        $electionKey = (string)$election;
        if(isset($this->statsOnElection[$electionKey])) {
            return $this->statsOnElection[$electionKey];
        }

        $this->statsOnElection[$electionKey] = new \mmp\rjpBundle\Library\Statistics\ElectionDistrict($election, $this);

        return $this->statsOnElection[$electionKey];
    }

    /**
     * Add houseNumbersWithStreets
     *
     * @param \mmp\rjpBundle\Entity\HouseNumber $houseNumbersWithStreets
     * @return District
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

    public function getStreetsXmlFile() {
        return $this->streetsXmlFile;
    }

    public function setStreetsXmlFile(UploadedFile $file = null) {
        if(!$file->isValid()) {
            return;
        }
        echo '<pre>';
        $xml = simplexml_load_file($file->getRealPath());
        $streetsModels = array();

        foreach($xml->way as $way) {
            $streetName = null;
            $houseNumber = null;

            foreach ($way->tag as $tag) {

                switch($tag['k']) {
                    case 'addr:street' :
                        $streetName = (string)$tag['v'];
                    break;
                    case 'addr:housenumber' :
                        $houseNumber = (string)$tag['v'];
                    break;
                }
            }

            if($streetName === null) {
                continue;
            }

            if($houseNumber === null) {
                $houseNumber = 0;
            }

            $streetModel = isset($streetsModels[$streetName]) ? $streetsModels[$streetName] : new Street;
            $streetModel->setName($streetName);
            $streetsModels[$streetName] = $streetModel;

            $houseNumberModel = new HouseNumber;
            $houseNumberModel->setStreet($streetModel);
            $houseNumberModel->setNumber($houseNumber);
            $houseNumberModel->setDistrict($this);

            $this->addHouseNumbersWithStreet($houseNumberModel);
        }

        $this->streetsXmlFile = $file;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/avatars';
    }
}
