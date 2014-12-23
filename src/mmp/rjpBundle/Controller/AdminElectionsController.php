<?php

namespace mmp\rjpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use mmp\rjpBundle\Form\ConfirmType;
use Symfony\Component\HttpFoundation\Request;
use mmp\rjpBundle\Entity\Election;
use mmp\rjpBundle\Form\ElectionType;

class AdminElectionsController extends Controller
{
    /**
     * @Route("/admin/elections", name="mmp_rjp_admin_elections")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $elections = $em->getRepository('mmpRjpBundle:Election')->findAll();

        return [
            'elections' => $elections
        ];
    }

    /**
     * @Route("/admin/elections/add", name="mmp_rjp_admin_election_add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $election = new Election;

        $form = $this->createForm(new ElectionType, $election);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em->persist($election);
            $em->flush();

            return $this->redirect($this->generateUrl('mmp_rjp_admin_elections'));
        }

        return [
            'form'  =>  $form->createView()
        ];
    }

    /**
     * @Route("/admin/elections/delete/{id}", name="mmp_rjp_admin_election_delete")
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $election = $em->getRepository('mmpRjpBundle:Election')->find($id);

        $form = $this->createForm(new ConfirmType, null);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em->remove($election);
            $em->flush(); 

            return $this->redirect($this->generateUrl('mmp_rjp_admin_elections'));
        }

        return [
            'form'     =>  $form->createView(),
            'election' => $election
        ];
    }

    /**
     * @Route("/admin/elections/edit/{id}", name="mmp_rjp_admin_election_edit")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $election = $em->getRepository('mmpRjpBundle:Election')->find($id);

        $form = $this->createForm(new ElectionType, $election);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em->persist($election);
            $em->flush();
            
            return $this->redirect($this->generateUrl('mmp_rjp_admin_elections'));
        }

        return [
            'form'  =>  $form->createView()
        ];
    }
}
