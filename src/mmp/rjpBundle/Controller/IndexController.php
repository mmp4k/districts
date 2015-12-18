<?php

namespace mmp\rjpBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    /**
     * @Route("/", name="_default")
     * @Template()
     */
    public function indexAction()
    {
        $districts = $this->getDistrictManager()->findOrderedBySlug();

        return [
            'districts'  => $districts,
            'councilors' => $this->getElectionManager()->findLastlyCouncilorsByDistricts($districts),
        ];
    }

    /**
     * @Route("/katowice/{slug}", name="mmp_rjp_district")
     * @Template()
     * @param string $slug
     * @return array
     */
    public function districtAction($slug)
    {
        $district = $this->getDistrictManager()->findOneBySlug($slug);

        return [
            'district'   => $district,
            'councilors' => $this->getElectionManager()->findLastlyCouncilorsByDistricts([$district]),
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
        return [
            'districts' => $this->getDistrictManager()->findWithLeaders(),
        ];
    }


    /**
     * @Route("/wybory", name="mmp_rjp_elections")
     * @Template()
     */
    public function electionsAction()
    {
        return [
            'elections' => $this->getElectionManager()->findWithDistrict(),
        ];
    }

    /**
     * @return \mmp\rjpBundle\Service\DistrictManager
     */
    protected function getDistrictManager()
    {
        return $this->get('rjp.manager.district');
    }

    /**
     * @return \mmp\rjpBundle\Service\ElectionManager
     */
    protected function getElectionManager()
    {
        return $this->get('rjp.manager.election');
    }
}
