<?php

namespace mmp\rjpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use mmp\rjpBundle\Entity\ElectoralCommission;
use mmp\rjpBundle\Entity\ElectionHasElectoralCommission;
use mmp\rjpBundle\Form\ElectionHasElectoralCommissionStreetsType;
use mmp\rjpBundle\Form\ElectoralCommissionType;
use mmp\rjpBundle\Form\ConfirmType;

class AdminElectoralCommissionsController extends Controller
{
    /**
     * @Route("/admin/electoral-commissions", name="mmp_rjp_admin_electoral_commissions")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $electoralCommissions = $em->getRepository('mmpRjpBundle:ElectoralCommission')->findAll();

        return [
            'electoralCommissions' => $electoralCommissions
        ];
    }

    /**
     * @Route("/admin/electoral-commission/map/{electionHasElectoralId}", name="mmp_rjp_admin_electoral_commission_map")
     * @Template()
     */
    public function mapAction($electionHasElectoralId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $electionHasElectoralCommission = $em->getRepository('mmpRjpBundle:ElectionHasElectoralCommission')->find($electionHasElectoralId);
        $electionHasElectoralCommissions = $em->getRepository('mmpRjpBundle:ElectionHasElectoralCommission')->findBy([
            'district' => $electionHasElectoralCommission->getDistrict(),
            'election' => $electionHasElectoralCommission->getElection()
        ]);

        return [
            'electionHasElectoralCommission'  =>  $electionHasElectoralCommission,
            'electionHasElectoralCommissions' => $electionHasElectoralCommissions,
        ];
    }

    /**
     * @Route("/admin/electoral-commission/streets/{electionHasElectoralId}", name="mmp_rjp_admin_electoral_commission_streets")
     * @Template()
     */
    public function streetsAction($electionHasElectoralId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $electionHasElectoralComission = $em->getRepository('mmpRjpBundle:ElectionHasElectoralCommission')->find($electionHasElectoralId);

        $form = $this->createForm(new ElectionHasElectoralCommissionStreetsType, $electionHasElectoralComission);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em->persist($electionHasElectoralComission);
            $em->flush();

            return $this->redirect($this->generateUrl('mmp_rjp_admin_electoral_commission_streets', [
                'electionHasElectoralId' => $electionHasElectoralId
            ]));
        }

        return [
            'form'  =>  $form->createView()
        ];
    }

    /**
     * @Route("/admin/electoral-commssion/delete/{id}", name="mmp_rjp_admin_electoral_commission_delete")
     * @Template()
     */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $electoralCommission = $em->getRepository('mmpRjpBundle:ElectoralCommission')->find($id);

        $form = $this->createForm(new ConfirmType, null);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em->remove($electoralCommission);
            $em->flush();
            return $this->redirect($this->generateUrl('mmp_rjp_admin_electoral_commissions'));
        }

        return [
            'form'                =>  $form->createView(),
            'electoralCommission' => $electoralCommission
        ];  
    }

    /**
     * @Route("/admin/electoral-commission/edit/{id}", name="mmp_rjp_admin_electoral_commission_edit")
     * @Template()
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $electoralCommission = $em->getRepository('mmpRjpBundle:ElectoralCommission')->find($id);

        $form = $this->createForm(new ElectoralCommissionType, $electoralCommission);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em->persist($electoralCommission);
            $em->flush();

            return $this->redirect($this->generateUrl('mmp_rjp_admin_electoral_commissions'));
        }

        return [
            'form'  =>  $form->createView()
        ];
    }

    /**
     * @Route("/admin/electoral-commissions/add", name="mmp_rjp_admin_electoral_commissions_add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $electoralCommission = new ElectoralCommission;
        $electionHasElectoralComission = new ElectionHasElectoralCommission;
        $electoralCommission->addElection($electionHasElectoralComission);

        $form = $this->createForm(new ElectoralCommissionType, $electoralCommission);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $electionHasElectoralComission->setElectoralCommission($electoralCommission);
            $em->persist($electionHasElectoralComission);
            $em->persist($electoralCommission);
            $em->flush();
            return $this->redirect($this->generateUrl('mmp_rjp_admin_electoral_commissions'));
        }

        return [
            'form' => $form->createView()
        ];
    }
}
