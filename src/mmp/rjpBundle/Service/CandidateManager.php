<?php

namespace mmp\rjpBundle\Service;

use Doctrine\ORM\EntityManager;
use mmp\rjpBundle\Entity\Candidate;
use mmp\rjpBundle\Entity\District;
use mmp\rjpBundle\Entity\Repository\CandidateRepository;

class CandidateManager
{
    protected $entityManager;

    protected $candidateRepository;

    public function __construct(CandidateRepository $candidateRepository, EntityManager $entityManager)
    {
        $this->candidateRepository = $candidateRepository;
        $this->entityManager = $entityManager;
    }

    public function findAll()
    {
        return $this->candidateRepository->findAll();
    }

    public function findByDistrict(District $district)
    {
        return $this->candidateRepository->findBy([
            'district' => $district,
        ]);
    }

    public function save(Candidate $candidate)
    {
        if (!$candidate->getDistrict()->getElections()->contains($candidate->getElection())) {
            $candidate->getElection()->addDistrict($candidate->getDistrict());
        }

        $this->entityManager->persist($candidate);
        $this->entityManager->flush($candidate);
    }

    public function delete(Candidate $candidate)
    {
        $this->entityManager->remove($candidate);
        $this->entityManager->flush($candidate);
    }
}
