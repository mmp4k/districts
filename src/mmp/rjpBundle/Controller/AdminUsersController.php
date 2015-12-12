<?php

namespace mmp\rjpBundle\Controller;

use mmp\rjpBundle\Form\ConfirmType;
use mmp\rjpBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminUsersController extends Controller
{
    /**
     * @Route("/admin/users", name="mmp_rjp_admin_users")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('mmpRjpBundle:User')->findAll();

        return array(
            'users' =>  $users
        );
    }

    /**
     * @Route("/admin/users/add", name="mmp_rjp_admin_user_add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $em   = $this->getDoctrine()->getManager();
        $um   = $this->get('fos_user.user_manager');
        $user = $um->createUser();//Original FOSUser line

        $form = $this->createForm(new UserType, $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            if($form->get('username')->isEmpty()) {
               $user->setUsername(uniqid("u", true));
               $user->setEmail(uniqid("e", true));
               $user->setPassword(uniqid("e", true));
            }
            $um->updateUser($user);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_users'));
        }

        return array(
            'form'  =>  $form->createView()
        );
    }

    /**
     * @Route("/admin/users/edit/{id}", name="mmp_rjp_admin_user_edit")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $um = $this->get('fos_user.user_manager');

        $user = $um->findUserBy(['id' => $id]);
        // if($user->getCouncilor()) {
        //    $user->setDistrict($user->getCouncilor()->getDistrict());
        // }

        $form = $this->createForm(new UserType, $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
        //     if(!$form->getData()->getDistrict() && $form->getData()->getCouncilor()) {
        //         $em->remove($form->getData()->getCouncilor());
        //     }

            $um->updateUser($user, true);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_users'));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/admin/users/delete/{id}", name="mmp_rjp_admin_user_delete")
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $um = $this->get('fos_user.user_manager');

        $user = $um->findUserBy(['id' => $id]);

        $form = $this->createForm(new ConfirmType, null);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $um->deleteUser($user);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_users'));
        }

        return array(
            'form' => $form->createView(),
            'user' => $user,
        );
    }
}
