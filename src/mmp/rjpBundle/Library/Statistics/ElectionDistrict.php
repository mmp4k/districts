<?php

namespace mmp\rjpBundle\Library\Statistics;

class ElectionDistrict
{
    /**
     * @var \mmp\rjpBundle\Entity\Election
     */
    protected $election;

    /**
     * @var \mmp\rjpBundle\Entity\District
     */
    protected $district;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $candidates;

    /**
     * @var array
     */
    protected $rangeAge;

    public function __construct(\mmp\rjpBundle\Entity\Election $election, \mmp\rjpBundle\Entity\District $district)
    {
        $this->election = $election;
        $this->district = $district;
        $this->candidates = $district->getCandidatesOnElection($election);

        $this->analysis();
    }

    public function getNumberOfMaleCandidates()
    {
        return $this->numberOfMaleCandidates;
    }

    public function getNumberOfFemaleCandidates()
    {
        return $this->numberOfFemaleCandidates;
    }

    public function getNumberOfCandidates()
    {
        return $this->numberOfCandidates;
    }

    public function getRangeAge()
    {
        return $this->rangeAge;
    }

    protected function incrementNumberPeopleBySex(\mmp\rjpBundle\Entity\Candidate $candidate)
    {
        if ($candidate->getSex() == 'm') {
            ++$this->numberOfMaleCandidates;
        } elseif ($candidate->getSex() == 'f') {
            ++$this->numberOfFemaleCandidates;
        }
    }

    protected function incrementRangeAge(\mmp\rjpBundle\Entity\Candidate $candidate)
    {
        if ($candidate->getAge() >= 18 && $candidate->getAge() <= 25) {
            ++$this->rangeAge['18-25'];
        } elseif ($candidate->getAge() >= 26 && $candidate->getAge() <= 40) {
            ++$this->rangeAge['26-40'];
        } elseif ($candidate->getAge() >= 41 && $candidate->getAge() <= 60) {
            ++$this->rangeAge['41-60'];
        } elseif ($candidate->getAge() >= 61) {
            ++$this->rangeAge['> 61'];
        }
    }

    protected function analysis()
    {
        $this->numberOfCandidates = count($this->candidates);
        $this->numberOfMaleCandidates = 0;
        $this->numberOfFemaleCandidates = 0;

        $this->rangeAge = [
            '18-25' => 0,
            '26-40' => 0,
            '41-60' => 0,
            '> 61' => 0,
        ];

        foreach ($this->candidates as $candidate) {
            $this->incrementNumberPeopleBySex($candidate);
            $this->incrementRangeAge($candidate);
        }
    }
}
