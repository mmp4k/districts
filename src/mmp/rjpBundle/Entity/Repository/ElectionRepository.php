<?php

namespace mmp\rjpBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ElectionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ElectionRepository extends EntityRepository
{
    public function findAllWithDistricts() {        
        $em = $this->getEntityManager();
        $elections = $this->findBy([], [
            'date' => 'desc'
        ]);

        foreach($elections as $election) {
            $districts = $election->getDistricts();

            foreach($districts as $district) {
                $qdb = $em->getRepository('mmpRjpBundle:Candidate')->createQueryBuilder('c');
                $qdb->join('c.user', 'u')->addSelect('u');
                $qdb->leftJoin('c.councilor', 'c2')->addSelect('c2');
                $qdb->where('c.district = :district AND c.election = :election');
                $qdb->setParameters([
                    'district' => $district->getId(),
                    'election' => $election->getId()
                ]);
                $qdb->groupBy('c.id');

                $candidates = $qdb->getQuery()->getResult();
                
                $district->addCandidatesOnElection(new \Doctrine\Common\Collections\ArrayCollection($candidates), $election);
                
            }
        }
        return $elections;
    }
}
