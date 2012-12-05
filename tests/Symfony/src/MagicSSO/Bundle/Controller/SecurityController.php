<?php
namespace MagicSSO\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Component\HttpFoundation\Response;

use JMS\SecurityExtraBundle\Annotation\Secure;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('MagicSSOBundle:Security:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }
    public function _internalAction()
    {
        return new Response('_internalAction page');
    }
    public function cartCheckoutAction()
    {
        return new Response('cartCheckoutAction page');
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function sec_annotationAction()
    {
        return new Response('sec_annotationAction page');

    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function ssoAddRoleAction()
    {

        // $this->addRole();
        return new Response('FOS_AddRoleAction');
    }
    private function _addRole()
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername('test5');
        $user->addRole('ROLE_ADMIN');
        $userManager->updateUser($user);
    }
}
