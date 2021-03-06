<?php

namespace mmp\MeetingBundle\Controller;

use mmp\MeetingBundle\Entity\Meeting;
use mmp\rjpBundle\Entity\District;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        return [
            'meetings' => $this->getMeetingManager()->findAll(),
        ];
    }

    /**
     * @Template()
     * @ParamConverter("district", class="mmpRjpBundle:District")
     *
     * @param District $district
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function meetingsByDistrictAction(District $district)
    {
        return [
            'meetings' => $this->getMeetingManager()->findAllFromDistrict($district),
            'district' => $district,
        ];
    }

    /**
     * @Template()
     *
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        $meeting = new Meeting();
        $form = $this->createForm('mmp_rjpbundle_meeting', $meeting);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getMeetingManager()->save($meeting);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_meetings'));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Template()
     * @ParamConverter("id", class="mmpMeetingBundle:Meeting")
     *
     * @param Request $request
     * @param Meeting $meeting
     *
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
            'form' => $form->createView(),
        ];
    }

    /**
     * @Template()
     * @ParamConverter("id", class="mmpMeetingBundle:Meeting")
     *
     * @param Request $request
     * @param Meeting $meeting
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Meeting $meeting)
    {
        $form = $this->createForm('confirm');
        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($form->get('yes')->isClicked()) {
                $this->getMeetingManager()->delete($meeting);
            }

            return $this->redirect($this->generateUrl('mmp_rjp_admin_meetings'));
        }

        return [
            'meeting' => $meeting,
            'form' => $form->createView(),
        ];
    }

    /**
     * @return \mmp\MeetingBundle\Service\MeetingManager
     */
    protected function getMeetingManager()
    {
        return $this->get('rjp.manager.meeting');
    }
}
