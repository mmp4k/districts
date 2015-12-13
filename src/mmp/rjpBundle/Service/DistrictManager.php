<?php

namespace mmp\rjpBundle\Service;

use mmp\rjpBundle\Entity\Repository\DistrictRepository;

class DistrictManager
{
    protected $districtRepository;

    public function __construct(DistrictRepository $districtRepository)
    {
        $this->districtRepository = $districtRepository;
    }

    public function findOrderedBySlug()
    {
        return $this->districtRepository->findBy([], ['slug' => 'ASC']);
    }

    public function findOneByElection($slug)
    {
        return $this->districtRepository->findOneByElections($slug);
    }

    public function findWithLeaders()
    {
        return $this->districtRepository->findAllWithLeaders();
    }
}