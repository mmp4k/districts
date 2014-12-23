<?php

namespace mmp\rjpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class IndexController extends Controller
{
    /**
     * @Route("/", name="_default")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $districts = $em->getRepository('mmpRjpBundle:District')->findAllDistrictsWithDetails();  

        return array(
            'districts' => $districts
        );
    }

    /**
     * @Route("/katowice/{slug}", name="mmp_rjp_district")
     * @Template()
     */
    public function districtAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $district = $em->getRepository('mmpRjpBundle:District')->findOneBy(['slug' => $slug]);

        return [
            'district'  =>  $district
        ];
    }

    /**
     * @Route("/katowice-mapa", name="mmp_rjp_map")
     * @Template()
     */
    public function mapAction()
    {        
        return [
            
        ];
    }

    /**
     * @Route("/liderzy-z-katowic", name="mmp_rjp_leaders")
     * @Template()
     */
    public function leadersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $districts = $em->getRepository('mmpRjpBundle:District')->findAllWithLeaders();

        return [
            'districts'  =>  $districts
        ];
    }
}
