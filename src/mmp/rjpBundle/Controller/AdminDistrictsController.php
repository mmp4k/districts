<?php

namespace mmp\rjpBundle\Controller;

use mmp\rjpBundle\Entity\District;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminDistrictsController extends Controller
{
    /**
     * @Route("/admin/districts", name="mmp_rjp_admin_districts")
     * @Template
     */
    public function indexAction()
    {
        return [
            'districts' => $this->getDistrictManager()->findAll(),
        ];
    }

    /**
     * @Route("/admin/districts/add", name="mmp_rjp_admin_districts_add")
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        $district = new District;
        $form = $this->createForm('mmp_rjpbundle_district', $district);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDistrictManager()->save($district);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_districts'));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/admin/stricts/streets/import/{id}", name="mmp_rjp_admin_districts_streets_import")
     * @Template()
     * @ParamConverter("id", class="mmpRjpBundle:District")
     * @param Request  $request
     * @param District $district
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function streetsImportAction(Request $request, District $district)
    {
        $form = $this->createForm('districtStreetsImport', $district);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDistrictManager()->save($district);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_district_streets', [
                'id' => $district->getId(),
            ]));
        }

        return [];
    }

    /**
     * @Route("/admin/stricts/streets/{id}", name="mmp_rjp_admin_district_streets")
     * @Template()
     * @ParamConverter("id", class="mmpRjpBundle:District")
     * @param District $district
     * @return array
     */
    public function streetsAction(District $district)
    {
        $form = $this->createForm('districtStreetsImport', $district, [
            'action' => $this->generateUrl('mmp_rjp_admin_districts_streets_import', [
                'id' => $district->getId(),
            ]),
        ]);

        return [
            'district' => $district,
            'form'     => $form->createView(),
        ];
    }

    /**
     * @Route("/admin/districts/edit/{id}", name="mmp_rjp_admin_district_edit")
     * @Template()
     * @ParamConverter("id", class="mmpRjpBundle:District")
     * @param Request  $request
     * @param District $district
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, District $district)
    {
        $form = $this->createForm('mmp_rjpbundle_district', $district);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDistrictManager()->save($district);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_districts'));
        }

        return [
            'district' => $district,
            'form'     => $form->createView(),
        ];
    }

    /**
     * @Route("/admin/districts/delete/{slug}", name="mmp_rjp_admin_district_delete")
     * @Template()
     * @ParamConverter("district", class="mmpRjpBundle:District")
     * @param Request  $request
     * @param District $district
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, District $district)
    {
        $form = $this->createForm('confirm');
        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($form->get('yes')->isClicked()) {
                $this->getDistrictManager()->delete($district);
            }

            return $this->redirect($this->generateUrl('mmp_rjp_admin_districts'));
        }

        return [
            'district' => $district,
            'form'     => $form->createView(),
        ];
    }

    /**
     * @return \mmp\rjpBundle\Service\DistrictManager
     */
    protected function getDistrictManager()
    {
        return $this->get('rjp.manager.district');
    }
}
