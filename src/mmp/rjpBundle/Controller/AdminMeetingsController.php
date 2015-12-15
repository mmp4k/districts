<?php

namespace mmp\rjpBundle\Controller;

use mmp\rjpBundle\Entity\Meeting;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminMeetingsController extends Controller
{
    /**
     * @Route("/admin/meetings/", name="mmp_rjp_admin_meetings")
     * @Template()
     */
    public function indexAction()
    {
        return [
            'meetings' => $this->getMeetingManager()->findAll(),
        ];
    }

    /**
     * @Route("/admin/meetings/add", name="mmp_rjp_admin_meeting_add")
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        $meeting = new Meeting;
        $form = $this->createForm('mmp_rjpbundle_meeting', $meeting);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $this->getMeetingManager()->save($meeting);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_meetings'));
        }

        return [
            'form'  =>  $form->createView()
        ];
    }

    /**
     * @Route("/admin/meetings/edit/{id}", name="mmp_rjp_admin_meeting_edit")
     * @Template()
     * @ParamConverter("id", class="mmpRjpBundle:Meeting")
     * @param Request $request
     * @param Meeting $meeting
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Meeting $meeting)
    {
        $form = $this->createForm('mmp_rjpbundle_meeting', $meeting);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $this->getMeetingManager()->save($meeting);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_meetings'));
        }

        return [
            'form'  =>  $form->createView()
        ];
    }

    /**
     * @Route("/admin/meetings/delete/{id}", name="mmp_rjp_admin_meeting_delete")
     * @Template()
     * @ParamConverter("id", class="mmpRjpBundle:Meeting")
     * @param Request $request
     * @param Meeting $meeting
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Meeting $meeting)
    {
        $form = $this->createForm('confirm');
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            if($form->get('yes')->isClicked()) {
                $this->getMeetingManager()->delete($meeting);
            }
            return $this->redirect($this->generateUrl('mmp_rjp_admin_meetings'));
        }

        return [
            'meeting' =>  $meeting,
            'form'    =>  $form->createView()
        ];
    }

    /**
     * @return \mmp\rjpBundle\Service\MeetingManager
     */
    protected function getMeetingManager()
    {
        return $this->get('rjp.manager.meeting');
    }
}
