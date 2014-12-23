<?php

namespace mmp\rjpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use mmp\rjpBundle\Form\ConfirmType;
use mmp\rjpBundle\Form\CandidateType;
use mmp\rjpBundle\Entity\Candidate;
use Symfony\Component\HttpFoundation\Request;

class AdminCandidatesController extends Controller
{
    /**
     * @Route("/admin/candidates", name="mmp_rjp_admin_candidates")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $candidates = $em->getRepository('mmpRjpBundle:Candidate')->findAll();

        return [
            'candidates' => $candidates
        ];
    }

    /**
     * @Route("/admin/candidates/add", name="mmp_rjp_admin_candidate_add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $candidate = new Candidate;

        $form = $this->createForm(new CandidateType, $candidate);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // echo '<pre>';
            // \Doctrine\Common\Util\Debug::dump($candidate);
            $em->persist($candidate);
            $em->flush();
            return $this->redirect($this->generateUrl('mmp_rjp_admin_candidates'));
        }

        return [
            'form'  =>  $form->createView()
        ];
    }

    /**
     * @Route("/admin/candidates/delete/{id}", name="mmp_rjp_admin_candidate_delete")
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $candidate = $em->getRepository('mmpRjpBundle:Candidate')->find($id);

        $form = $this->createForm(new ConfirmType, null);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em->remove($candidate);
            $em->flush();

            return $this->redirect($this->generateUrl('mmp_rjp_admin_candidates'));
        }

        return [
            'candidate' =>  $candidate,
            'form'      =>  $form->createView()
        ];
    }

    /**
     * @Route("/admin/candidates/edit/{id}", name="mmp_rjp_admin_candidate_edit")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $candidate = $em->getRepository('mmpRjpBundle:Candidate')->find($id);

        $form = $this->createForm(new CandidateType, $candidate);
            
        $form->handleRequest($request);
            
        if ($form->isValid()) {
            $em->persist($candidate);
            $em->flush();

            return $this->redirect($this->generateUrl('mmp_rjp_admin_candidates'));
        }   

        return [
            'form'  =>  $form->createView()
        ]; 
    }
}
