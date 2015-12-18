<?php

namespace mmp\MeetingsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        return [
            'meetings' => $this->getMeetingManager()->newestFirst(),
        ];
    }

    /**
     * @return \mmp\MeetingsBundle\Service\MeetingManager
     */
    protected function getMeetingManager()
    {
        return $this->get('rjp.manager.meeting');
    }
}
