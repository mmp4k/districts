<?php

namespace mmp\rjpBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use mmp\rjpBundle\Entity\ElectionHasElectoralCommission;
use mmp\rjpBundle\Entity\ElectoralCommission;

class ElectoralCommissionManager
{
    protected $electoralCommissionRepository;

    protected $entityManager;

    protected $electionHasElectoralCommission;

    public function __construct(EntityRepository $electoralCommissionRepository,
                                EntityManager $entityManager,
                                EntityRepository $electionHasElectoralCommission)
    {
        $this->electoralCommissionRepository = $electoralCommissionRepository;
        $this->entityManager = $entityManager;
        $this->electionHasElectoralCommission = $electionHasElectoralCommission;
    }

    public function findAll()
    {
        return $this->electoralCommissionRepository->findAll();
    }

    public function findRelated(ElectionHasElectoralCommission $electionHasElectoralCommission)
    {
        return $this->electionHasElectoralCommission->findBy([
            'district' => $electionHasElectoralCommission->getDistrict(),
            'election' => $electionHasElectoralCommission->getElection(),
        ]);
    }

    public function saveElectionHasElectoralCommission(ElectionHasElectoralCommission $electionHasElectoralCommission)
    {
        $this->entityManager->persist($electionHasElectoralCommission);
        $this->entityManager->flush($electionHasElectoralCommission);
    }

    public function save(ElectoralCommission $electoralCommission,
                         ElectionHasElectoralCommission $electionHasElectoralCommission = null)
    {
        if (null !== $electionHasElectoralCommission) {
            $electionHasElectoralCommission->setElectoralCommission($electoralCommission);
            $this->entityManager->persist($electionHasElectoralCommission);
        }

        $this->entityManager->persist($electoralCommission);
        $this->entityManager->flush($electoralCommission);
    }

    public function delete(ElectoralCommission $electoralCommission)
    {
        $this->entityManager->remove($electoralCommission);
        $this->entityManager->flush($electoralCommission);
    }
}