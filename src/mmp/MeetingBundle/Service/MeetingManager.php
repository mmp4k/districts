<?php

namespace mmp\MeetingBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use mmp\MeetingBundle\Entity\Meeting;

class MeetingManager
{
    /**
     * @var EntityRepository
     */
    protected $meetingRepository;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityRepository $meetingRepository
     * @param EntityManager    $entityManager
     */
    public function __construct(EntityRepository $meetingRepository, EntityManager $entityManager)
    {
        $this->meetingRepository = $meetingRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return Meeting
     */
    public function newestFirst()
    {
        return $this->meetingRepository->findBy([], [
            'date' => 'desc',
        ]);
    }

    /**
     * @return array|Meeting[]
     */
    public function findAll()
    {
        return $this->meetingRepository->findAll();
    }

    /**
     * @param Meeting $meeting
     */
    public function save(Meeting $meeting)
    {
        $this->entityManager->persist($meeting);
        $this->entityManager->flush($meeting);
    }

    /**
     * @param Meeting $meeting
     */
    public function delete(Meeting $meeting)
    {
        $this->entityManager->remove($meeting);
        $this->entityManager->flush($meeting);
    }
}