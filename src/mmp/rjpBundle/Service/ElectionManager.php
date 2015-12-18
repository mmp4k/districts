<?php

namespace mmp\rjpBundle\Service;

use Doctrine\ORM\EntityManager;
use mmp\rjpBundle\Entity\Election;
use mmp\rjpBundle\Entity\Repository\ElectionRepository;

class ElectionManager
{
    protected $electionRepository;

    protected $entityManager;

    public function __construct(ElectionRepository $electionRepository, EntityManager $entityManager)
    {
        $this->electionRepository = $electionRepository;
        $this->entityManager = $entityManager;
    }

    public function findLastlyCouncilorsByDistricts(array $districts)
    {
        return $this->electionRepository->findLastlyCouncilorsByDistricts($districts);
    }

    public function findWithDistrict()
    {
        return $this->electionRepository->findAllWithDistricts();
    }

    public function findAll()
    {
        return $this->electionRepository->findAll();
    }

    public function save(Election $election)
    {
        $this->entityManager->persist($election);
        $this->entityManager->flush($election);
    }

    public function delete(Election $election)
    {
        $this->entityManager->remove($election);
        $this->entityManager->flush($election);
    }
}