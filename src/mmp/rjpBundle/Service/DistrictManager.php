<?php

namespace mmp\rjpBundle\Service;

use Doctrine\ORM\EntityManager;
use mmp\rjpBundle\Entity\District;
use mmp\rjpBundle\Entity\Repository\DistrictRepository;

class DistrictManager
{
    protected $districtRepository;

    protected $entityManager;

    public function __construct(DistrictRepository $districtRepository, EntityManager $entityManager)
    {
        $this->districtRepository = $districtRepository;
        $this->entityManager = $entityManager;
    }

    public function findOrderedBySlug()
    {
        return $this->districtRepository->findBy([], ['slug' => 'ASC']);
    }

    public function findOneBySlug($slug)
    {
        return $this->districtRepository->findOneBy([
            'slug' => $slug,
        ]);
    }

    public function findOneByElection($slug)
    {
        return $this->districtRepository->findOneByElections($slug);
    }

    public function findWithLeaders()
    {
        return $this->districtRepository->findAllWithLeaders();
    }

    public function findAll()
    {
        return $this->districtRepository->findAll();
    }

    public function save(District $district)
    {
        $this->entityManager->persist($district);
        $this->entityManager->flush($district);
    }

    public function delete(District $district)
    {
        $this->entityManager->remove($district);
        $this->entityManager->flush($district);
    }
}
