<?php

namespace mmp\rjpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use mmp\rjpBundle\Form\DistrictType;
use mmp\rjpBundle\Form\ConfirmType;
use mmp\rjpBundle\Form\DistrictStreetsImportType;
use mmp\rjpBundle\Entity\District;
use Symfony\Component\HttpFoundation\Request;

class AdminDistrictsController extends Controller
{
    /**
     * @Route("/admin/districts", name="mmp_rjp_admin_districts")
     * @Template
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $districts = $em->getRepository('mmpRjpBundle:District')->findAll();
        
        return array(
            'districts'  =>  $districts
        );
    }

    /**
     * @Route("/admin/districts/add", name="mmp_rjp_admin_districts_add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $district = new District;

        $form = $this->createForm(new DistrictType, $district);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em->persist($district);
            $em->flush();

            return $this->redirect($this->generateUrl('mmp_rjp_admin_districts'));
        }

        return array(
            'form'  =>  $form->createView()
            );
    }

    /**
     * @Route("/admin/stricts/streets/import/{id}", name="mmp_rjp_admin_districts_streets_import")
     * @Template()
     */
    public function streetsImportAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $district = $em->getRepository('mmpRjpBundle:District')->find($id);
        $form = $this->createForm(new DistrictStreetsImportType(), $district);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em->persist($district);
            $em->flush();
            
            return $this->redirect($this->generateUrl('mmp_rjp_admin_district_streets', [
                'id' => $id
            ]));
        }
    }

    /**
     * @Route("/admin/stricts/streets/{id}", name="mmp_rjp_admin_district_streets")
     * @Template()
     */
    public function streetsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $district = $em->getRepository('mmpRjpBundle:District')->find($id);

        $form = $this->createForm(new DistrictStreetsImportType, $district, [
            'action' => $this->generateUrl('mmp_rjp_admin_districts_streets_import', [
                'id' => $id
            ])
        ]);

        return [
            'district' => $district,
            'form'     => $form->createView()
        ];
    }

    /**
     * @Route("/admin/districts/edit/{id}", name="mmp_rjp_admin_district_edit")
     * @Template()
     */
    public function editAction($id, Request $request)
    {
        $em       = $this->getDoctrine()->getManager();
        $district = $em->getRepository('mmpRjpBundle:District')->findOneById($id);

        $form = $this->createForm(new DistrictType, $district);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em->persist($district);
            $em->flush();
            
            return $this->redirect($this->generateUrl('mmp_rjp_admin_districts'));
        }   

        return array(
            'district' => $district,
            'form'     => $form->createView()
            );
    }

    /**
     * @Route("/admin/districts/delete/{slug}", name="mmp_rjp_admin_district_delete")
     * @Template()
     */
    public function deleteAction($slug, Request $request)
    {
        $em       = $this->getDoctrine()->getManager();
        $district = $em->getRepository('mmpRjpBundle:District')->findOneBySlug($slug);

        $form = $this->createForm(new ConfirmType, null);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            if($form->get('yes')->isClicked()) {
                $em->remove($district);
                $em->flush();
            }
            return $this->redirect($this->generateUrl('mmp_rjp_admin_districts'));
        }

        return array(
            'district'  =>  $district,
            'form'      =>  $form->createView()
            );
    }
}
