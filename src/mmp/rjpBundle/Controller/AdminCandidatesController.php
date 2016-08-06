<?php

namespace mmp\rjpBundle\Controller;

use mmp\rjpBundle\Entity\Candidate;
use mmp\rjpBundle\Entity\District;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminCandidatesController extends Controller
{
    /**
     * @Route("/admin/candidates", name="mmp_rjp_admin_candidates")
     * @Template()
     */
    public function indexAction()
    {
        return [
            'candidates' => $this->getCandidateManager()->findAll(),
            'districts' => $this->getDistrictManager()->findOrderedBySlug(),
        ];
    }

    /**
     * @Route("/admin/candidates/id/{id}", name="mmp_rjp_admin_candidates_from_district")
     * @Template()
     * @ParamConverter("district", class="mmpRjpBundle:District")
     *
     * @param Request  $request
     * @param District $district
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function candidatesByDistrictAction(Request $request, District $district)
    {
        $candidates = $this->getCandidateManager()->findByDistrict($district);

        $form = $this->createForm('districtWithCandidates', $district);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDistrictManager()->save($district);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_candidates_from_district', [
                'id' => $district->getId(),
            ]));
        }

        return [
            'district' => $district,
            'candidates' => $candidates,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/admin/candidates/add", name="mmp_rjp_admin_candidate_add")
     * @Template()
     *
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $candidate = new Candidate();
        $candidate->setElection($em->getRepository('mmpRjpBundle:Election')->find(11));
        $candidate->setDistrict($em->getRepository('mmpRjpBundle:District')->find(15));

        $form = $this->createForm('mmp_rjpbundle_candidate', $candidate);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getCandidateManager()->save($candidate);

            $this->addFlash('success', 'Kandydat został dodany');

            return $this->redirect($this->generateUrl('mmp_rjp_admin_candidate_add'));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/admin/candidates/delete/{id}", name="mmp_rjp_admin_candidate_delete")
     * @Template()
     * @ParamConverter("candidate", class="mmpRjpBundle:Candidate")
     *
     * @param Request   $request
     * @param Candidate $candidate
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Candidate $candidate)
    {
        $form = $this->createForm('confirm');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getCandidateManager()->delete($candidate);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_candidates'));
        }

        return [
            'candidate' => $candidate,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/admin/candidates/edit/{id}", name="mmp_rjp_admin_candidate_edit")
     * @Template()
     * @ParamConverter("candidate", class="mmpRjpBundle:Candidate")
     *
     * @param Request   $request
     * @param Candidate $candidate
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Candidate $candidate)
    {
        $form = $this->createForm('mmp_rjpbundle_candidate', $candidate);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getCandidateManager()->save($candidate);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_candidates'));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @return \mmp\rjpBundle\Service\CandidateManager
     */
    protected function getCandidateManager()
    {
        return $this->get('rjp.manager.candidate');
    }

    /**
     * @return \mmp\rjpBundle\Service\DistrictManager
     */
    protected function getDistrictManager()
    {
        return $this->get('rjp.manager.district');
    }
}
