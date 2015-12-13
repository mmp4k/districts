<?php

namespace mmp\rjpBundle\Controller;

use mmp\rjpBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
        return [
            'users' => $this->getUserManager()->findUsers(),
        ];
    }

    /**
     * @Route("/admin/users/add", name="mmp_rjp_admin_user_add")
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        $user = $this->getUserManager()->createUser();
        $form = $this->createForm('mmp_rjpbundle_user', $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            if (!$user->getUsername()) {
               $user->setUsername(uniqid("u", true));
               $user->setEmail(uniqid("e", true));
               $user->setPassword(uniqid("e", true));
            }
            $this->getUserManager()->updateUser($user);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_users'));
        }

        return [
            'form'  =>  $form->createView()
        ];
    }

    /**
     * @Route("/admin/users/edit/{id}", name="mmp_rjp_admin_user_edit")
     * @Template()
     * @ParamConverter("id", class="mmpRjpBundle:User")
     * @param Request $request
     * @param User    $user
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, User $user)
    {
        $form = $this->createForm('mmp_rjpbundle_user', $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getUserManager()->updateUser($user);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_users'));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/admin/users/delete/{id}", name="mmp_rjp_admin_user_delete")
     * @Template()
     * @ParamConverter("id", class="mmpRjpBundle:User")
     * @param Request $request
     * @param User    $user
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createForm('confirm');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getUserManager()->deleteUser($user);

            return $this->redirect($this->generateUrl('mmp_rjp_admin_users'));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @return \FOS\UserBundle\Doctrine\UserManager
     */
    protected function getUserManager()
    {
        return $this->get('fos_user.user_manager');
    }
}
