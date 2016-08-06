<?php

namespace mmp\rjpBundle\Controller;

use mmp\rjpBundle\Entity\ElectionHasElectoralCommission;
use mmp\rjpBundle\Entity\ElectoralCommission;
use mmp\rjpBundle\Form\ElectoralCommissionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminElectoralCommissionsController extends Controller
{
    /**
     * @Route("/admin/electoral-commissions", name="mmp_rjp_admin_electoral_commissions")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        return [
            'electoralCommissions' => $this->getElectoralCommissionManager()->findAll(),
        ];
    }

    /**
     * @Route("/admin/electoral-commission/map/{electionHasElectoralId}", name="mmp_rjp_admin_electoral_commission_map")
     * @Template()
     * @ParamConverter("electionHasElectoralId", class="mmpRjpBundle:ElectionHasElectoralCommission")
     *
     * @param ElectionHasElectoralCommission $electionHasElectoralCommission
     *
     * @return array
     */
    public function mapAction(ElectionHasElectoralCommission $electionHasElectoralCommission)
    {
        return [
            'electionHasElectoralCommission' => $electionHasElectoralCommission,
            'electionHasElectoralCommissions' => $this->getElectoralCommissionManager()->findRelated($electionHasElectoralCommission),
        ];
    }

    /**
     * @Route("/admin/electoral-commission/streets/{electionHasElectoralId}", name="mmp_rjp_admin_electoral_commission_streets")
     * @Template()
     * @ParamConverter("electionHasElectoralId", class="mmpRjpBundle:ElectionHasElectoralCommission")
     *
     * @param Request                        $request
     * @param ElectionHasElectoralCommission $electionHasElectoralCommission
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function streetsAction(Request $request, ElectionHasElectoralCommission $electionHasElectoralCommission)
    {
        $form = $this->createForm('mmp_rjpbundle_electionhaselectoralcommission', $electionHasElectoralCommission);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getElectoralCommissionManager()->saveElectionHasElectoralCommission($electionHasElectoralCommission);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_electoral_commission_streets', [
                'electionHasElectoralId' => $electionHasElectoralCommission->getId(),
            ]));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/admin/electoral-commssion/delete/{id}", name="mmp_rjp_admin_electoral_commission_delete")
     * @Template()
     * @ParamConverter("id", class="mmpRjpBundle:ElectoralCommission")
     *
     * @param Request             $request
     * @param ElectoralCommission $electoralCommission
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, ElectoralCommission $electoralCommission)
    {
        $form = $this->createForm('confirm');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getElectoralCommissionManager()->delete($electoralCommission);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_electoral_commissions'));
        }

        return [
            'form' => $form->createView(),
            'electoralCommission' => $electoralCommission,
        ];
    }

    /**
     * @Route("/admin/electoral-commission/edit/{id}", name="mmp_rjp_admin_electoral_commission_edit")
     * @Template()
     * @ParamConverter("id", class="mmpRjpBundle:ElectoralCommission")
     *
     * @param Request             $request
     * @param ElectoralCommission $electoralCommission
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, ElectoralCommission $electoralCommission)
    {
        $form = $this->createForm('mmp_rjpbundle_electoralcommission', $electoralCommission);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getElectoralCommissionManager()->save($electoralCommission);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_electoral_commissions'));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/admin/electoral-commissions/add", name="mmp_rjp_admin_electoral_commissions_add")
     * @Template()
     *
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        $electoralCommission = new ElectoralCommission();
        $electionHasElectoralCommission = new ElectionHasElectoralCommission();
        $electoralCommission->addElection($electionHasElectoralCommission);

        $form = $this->createForm(new ElectoralCommissionType(), $electoralCommission);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getElectoralCommissionManager()->save($electoralCommission, $electionHasElectoralCommission);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_electoral_commissions'));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    protected function getElectoralCommissionManager()
    {
        return $this->get('rjp.manager.electoral_commission');
    }
}
