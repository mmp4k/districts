<?php

namespace mmp\rjpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use mmp\rjpBundle\Form\ConfirmType;
use mmp\rjpBundle\Form\CandidateType;
use mmp\rjpBundle\Form\DistrictWithCandidatesType;
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
     * @Route("/admin/candidates/{id}", name="mmp_rjp_admin_candidates_from_district")
     * @Template()
     */
    public function candidatesByDistrictAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $district   = $em->getRepository('mmpRjpBundle:District')->find($id);
        $candidates = $em->getRepository('mmpRjpBundle:Candidate')->findBy([
            'district' => $id
        ]);

        $form = $this->createForm(new DistrictWithCandidatesType, $district);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {            
            $em->persist($district);
            $em->flush();
            return $this->redirect($this->generateUrl('mmp_rjp_admin_candidates_from_district', [
                'id' => $id
            ]));
        }

        return [
            'district'   => $district,
            'candidates' => $candidates,
            'form'       => $form->createView()
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
        $candidate->setElection($em->getRepository('mmpRjpBundle:Election')->find(7));
        $candidate->setDistrict($em->getRepository('mmpRjpBundle:District')->find(14));//dąbrówka

        $form = $this->createForm(new CandidateType, $candidate);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {            
            if(!$candidate->getDistrict()->getElections()->contains($candidate->getElection())) {
                $candidate->getElection()->addDistrict($candidate->getDistrict());                
            }
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
