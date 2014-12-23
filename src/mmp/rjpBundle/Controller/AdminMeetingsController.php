<?php

namespace mmp\rjpBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use mmp\rjpBundle\Form\ConfirmType;
use Symfony\Component\HttpFoundation\Request;
use mmp\rjpBundle\Entity\Meeting;
use mmp\rjpBundle\Form\MeetingType;

class AdminMeetingsController extends Controller
{
    /**
     * @Route("/admin/meetings/", name="mmp_rjp_admin_meetings")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $meetings = $em->getRepository('mmpRjpBundle:meeting')->findAll();
        return array(
            'meetings'  =>  $meetings
        );
    }

    /**
     * @Route("/admin/meetings/add", name="mmp_rjp_admin_meeting_add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $meeting = new Meeting;

        $form = $this->createForm(new MeetingType, $meeting);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em->persist($meeting);
            $em->flush();

            return $this->redirect($this->generateUrl('mmp_rjp_admin_meetings'));
        }

        return array(
            'form'  =>  $form->createView()
        );
    }

    /**
     * @Route("/admin/meetings/edit/{id}", name="mmp_rjp_admin_meeting_edit")
     * @Template()
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $meeting = $em->getRepository('mmpRjpBundle:Meeting')->find($id);

        $form = $this->createForm(new MeetingType, $meeting);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em->persist($meeting);
            $em->flush();

            return $this->redirect($this->generateUrl('mmp_rjp_admin_meetings'));
        }
        return array(
            'form'  =>  $form->createView()
        );
    }

    /**
     * @Route("/admin/meetings/delete/{id}", name="mmp_rjp_admin_meeting_delete")
     * @Template()
     */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $meeting = $em->getRepository('mmpRjpBundle:Meeting')->find($id);

        $form = $this->createForm(new ConfirmType, null);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            if($form->get('yes')->isClicked()) {
                $em->remove($meeting);
                $em->flush();
            }
            return $this->redirect($this->generateUrl('mmp_rjp_admin_meetings'));
        }


        return array(
            'meeting' =>  $meeting,
            'form'    =>  $form->createView()
        );
    }
}
