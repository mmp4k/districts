<?php

namespace mmp\rjpBundle\Controller;

use mmp\rjpBundle\Entity\Election;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminElectionsController extends Controller
{
    /**
     * @Route("/admin/elections", name="mmp_rjp_admin_elections")
     * @Template()
     */
    public function indexAction()
    {
        return [
            'elections' => $this->getElectionManager()->findAll(),
        ];
    }

    /**
     * @Route("/admin/elections/add", name="mmp_rjp_admin_election_add")
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        $election = new Election;
        $form = $this->createForm('mmp_rjpbundle_election', $election);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getElectionManager()->save($election);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_elections'));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/admin/elections/delete/{id}", name="mmp_rjp_admin_election_delete")
     * @Template()
     * @ParamConverter("id", class="mmpRjpBundle:Election")
     * @param Request  $request
     * @param Election $election
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Election $election)
    {
        $form = $this->createForm('confirm');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getElectionManager()->delete($election);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_elections'));
        }

        return [
            'form'     => $form->createView(),
            'election' => $election,
        ];
    }

    /**
     * @Route("/admin/elections/edit/{id}", name="mmp_rjp_admin_election_edit")
     * @Template()
     * @ParamConverter("id", class="mmpRjpBundle:Election")
     * @param Request  $request
     * @param Election $election
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @internal param $id
     */
    public function editAction(Request $request, Election $election)
    {
        $form = $this->createForm('mmp_rjpbundle_election', $election);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getElectionManager()->save($election);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_elections'));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @return \mmp\rjpBundle\Service\ElectionManager
     */
    protected function getElectionManager()
    {
        return $this->get('rjp.manager.election');
    }
}
