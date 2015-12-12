<?php

namespace mmp\rjpBundle\Entity\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * DistrictRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DistrictRepository extends EntityRepository
{   
    public function findOneByElections($rules, $order = null) {
        $em = $this->getEntityManager();
        $district = $this->findOneBy($rules, $order);
        
        foreach($district->getElections() as $election) {
            $qdb = $em->getRepository('mmpRjpBundle:Candidate')->createQueryBuilder('c');
            $qdb->join('c.user', 'u')->addSelect('u');
            $qdb->leftJoin('c.councilor', 'c2')->addSelect('c2');
            $qdb->where('c.district = :district AND c.election = :election');
            $qdb->setParameters([
                'district' => $district->getId(),
                'election' => $election->getId()
            ]);
            $qdb->orderBy('u.last_name', 'ASC');
            $qdb->groupBy('c.id');

            $candidates = $qdb->getQuery()->getResult();
                
            $district->addCandidatesOnElection(new \Doctrine\Common\Collections\ArrayCollection($candidates), $election);
        }
          

        return $district;
    }
    public function findAllWithLeaders() {
        $districts = $this->findBy([], [
            'slug'  =>  'asc'
        ]);

        foreach($districts as $key => $district) {
            $qdb = $this->getEntityManager()->getRepository('mmpRjpBundle:Councilor')->createQueryBuilder('c');
            $qdb->join('c.candidate', 'ct')->addSelect('ct');
            $qdb->join('ct.user', 'u')->addSelect('u');
            $qdb->where('c.district = :district');
            $qdb->setParameter('district', $district);
            $qdb->orderBy('ct.votes', 'DESC');
            $qdb->setMaxResults(3);

            $counilors = $qdb->getQuery()->getResult();
            if(!$counilors) {
                unset($districts[$key]);
            }

            $district->getCouncilors()->clear();
            foreach($counilors as $councilor) {
                $district->addCouncilor($councilor);
            }
        }

        return $districts;
    }
    public function findAllDistrictsWithDetails() {
        $districts = $this->findBy([], [
            'slug' => 'asc'
        ]);
        
        foreach($districts as $district) {
            $qdb = $this->getEntityManager()->getRepository('mmpRjpBundle:Councilor')->createQueryBuilder('c');            
            $qdb->join('c.candidate', 'ct')->addSelect('ct');
            $qdb->join('ct.user', 'u')->addSelect('u');
            $qdb->where('c.district = :district');
            $qdb->setParameter('district', $district);
            $qdb->orderBy('u.last_name', 'ASC');

            $district->getCouncilors()->clear();
            foreach($qdb->getQuery()->getResult() as $councilor) {
                $district->addCouncilor($councilor);
            }
        }

        return $districts;
    }
}
