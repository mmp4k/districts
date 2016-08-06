<?php

namespace mmp\rjpBundle\Library\Statistics;

class Election
{
    /**
     * @var \mmp\rjpBundle\Entity\Election
     */
    protected $election;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $candidates;

    protected $sumAge;
    protected $personsWithAge;
    protected $avgAge;
    protected $sumPersons;
    protected $numberOfMaleCandidates;
    protected $numberOfFemaleCandidates;
    protected $rangeAge;

    public function __construct(\mmp\rjpBundle\Entity\Election $election)
    {
        $this->election = $election;
        $this->candidates = $election->getCandidates();

        $this->analysis();
    }

    public function getSumAge()
    {
        return $this->sumAge;
    }

    public function getPersonsWithAge()
    {
        return $this->personsWithAge;
    }

    public function getAvgAge()
    {
        return $this->avgAge;
    }

    public function getSumPersons()
    {
        return $this->sumPersons;
    }

    public function getNumberOfMaleCandidates()
    {
        return $this->numberOfMaleCandidates;
    }

    public function getNumberOfFemaleCandidates()
    {
        return $this->numberOfFemaleCandidates;
    }

    public function getRangeAge()
    {
        return $this->rangeAge;
    }

    protected function analysisAge(\mmp\rjpBundle\Entity\Candidate $candidate)
    {
        if ($candidate->getAge()) {
            $this->sumAge += $candidate->getAge();
            ++$this->personsWithAge;
            $this->avgAge = intval($this->sumAge / $this->personsWithAge);
        }
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
        $this->sumAge = 0;
        $this->personsWithAge = 0;
        $this->avgAge = 0;
        $this->sumPersons = count($this->candidates);

        $this->numberOfMaleCandidates = 0;
        $this->numberOfFemaleCandidates = 0;

        $this->rangeAge = [
            '18-25' => 0,
            '26-40' => 0,
            '41-60' => 0,
            '> 61' => 0,
        ];
        foreach ($this->candidates as $candidate) {
            $this->analysisAge($candidate);
            $this->incrementNumberPeopleBySex($candidate);
            $this->incrementRangeAge($candidate);
        }
    }
}
