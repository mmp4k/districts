<?php

namespace mmp\rjpBundle\Service;

use mmp\rjpBundle\Entity\Repository\ElectionRepository;

class ElectionManager
{
    protected $electionRepository;

    public function __construct(ElectionRepository $electionRepository)
    {
        $this->electionRepository = $electionRepository;
    }

    public function findLastlyCouncilorsByDistricts(array $districts)
    {
        return $this->electionRepository->findLastlyCouncilorsByDistricts($districts);
    }

    public function findWithDistrict()
    {
        return $this->electionRepository->findAllWithDistricts();
    }
}