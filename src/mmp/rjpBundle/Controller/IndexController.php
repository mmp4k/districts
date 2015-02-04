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
        $district = $em->getRepository('mmpRjpBundle:District')->findOneByElections(['slug' => $slug]);

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

    /**
     * @Route("/spotkania-mieszkancow", name="mmp_rjp_meetings")
     * @Template()
     */
    public function meetingsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $meetings = $em->getRepository('mmpRjpBundle:Meeting')->findBy([], [
            'date' => 'desc'
        ]);

        return [
            'meetings' => $meetings
        ];
    }

    /**
     * @Route("/wybory", name="mmp_rjp_elections")
     * @Template()
     */
    public function electionsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $elections = $em->getRepository('mmpRjpBundle:Election')->findAllWithDistricts();

        return [
            'elections' => $elections
        ];
    }
}
