<?php

namespace mmp\rjpBundle\Service;

use Doctrine\ORM\EntityRepository;

class MeetingManager
{
    protected $meetingRepository;

    public function __construct(EntityRepository $meetingRepository)
    {
        $this->meetingRepository = $meetingRepository;
    }

    public function newestFirst()
    {
        return $this->meetingRepository->findBy([], [
            'date' => 'desc',
        ]);
    }
}